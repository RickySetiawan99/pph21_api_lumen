<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\Helper;
use App\Repositories\EmployeeRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Faker\Factory as Faker;

class EmployeeController extends Controller
{
    protected $employeeRepository;

    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function list()
    {
        try {

            $data = $this->employeeRepository->getAllEmployee(null, Carbon::now()->format('Y-m-d'));

            $result = Helper::setResults($data);

            return $this->resSuccess(null, $result['res_status'], $result['msg'], $result['status_msg'], $result['result']);
        } catch (\Throwable $th) {

            $error = [
                'error' => $th,
            ];
            return $this->resCatchError($error);
        }
    }

    public function detail($employeeId)
    {
        try {
            $param = [
                'employee_id' => $employeeId,
            ];

            $data = $this->employeeRepository->getEmployee($param);

            $result = Helper::setResults($data);

            return $this->resSuccess($param, $result['res_status'], $result['msg'], $result['status_msg'], $result['result']);
        } catch (\Throwable $th) {

            $error = [
                'error' => $th,
            ];
            return $this->resCatchError($error);
        }
    }

    public function listByWorkingUnit($workingUnitId)
    {
        try {
            $param = [
                'working_unit_id' => $workingUnitId,
            ];

            $data = $this->employeeRepository->getAllEmployee($param['working_unit_id']);

            $result = Helper::setResults($data);

            return $this->resSuccess($param, $result['res_status'], $result['msg'], $result['status_msg'], $result['result']);
        } catch (\Throwable $th) {

            $error = [
                'error' => $th,
            ];
            return $this->resCatchError($error);
        }
    }

    public function create(Request $request)
    {
        try {

            $dataRequest = $request->all();

            $rules = [
                'employee_no'             => 'required|is_unique[employees.employee_no]',
                'name'                    => 'required',
                'npwp'                    => 'required',
                'nik_ktp'                 => 'required',
                'current_working_unit_id' => 'required',
                'ptkp_id'                 => 'required',
                'email'                   => 'required|is_unique[employees.email]',
                'is_marriage'             => 'required',
                'is_permanent_employee'   => 'required',
                'jumlah_tanggungan'       => 'required',
                'no_rekening'             => 'required|is_unique[employees.no_rekening]',
                'status_id'               => 'required',
                'type_id'                 => 'required',
                'address'                 => 'required',
                'gender'                  => 'required',
            ];

            $validator = Validator::make($dataRequest, $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation Error',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $data = $this->employeeRepository->createEmployee($dataRequest);

            $result = Helper::setResults($data);

            return $this->resSuccess($data, $result['res_status'], $result['msg'], $result['status_msg'], $result['result']);
        } catch (\Throwable $th) {

            $error = [
                'error' => $th,
            ];
            return $this->resCatchError($error);
        }
    }

    public function createMultiple(Request $request)
    {
        $data = $request->all();

        $rules = [
            'employee_no'             => 'required|is_unique[employees.employee_no]',
            'name'                    => 'required',
            'npwp'                    => 'required',
            'nik_ktp'                 => 'required',
            'current_working_unit_id' => 'required',
            'ptkp_id'                 => 'required',
            'email'                   => 'required|is_unique[employees.email]',
            'is_marriage'             => 'required',
            'is_permanent_employee'   => 'required',
            'jumlah_tanggungan'       => 'required',
            'no_rekening'             => 'required|is_unique[employees.no_rekening]',
            'status_id'               => 'required',
            'type_id'                 => 'required',
            'address'                 => 'required',
            'gender'                  => 'required',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors(),
            ], 422);
        }

        DB::beginTransaction();
        try {
            foreach ($data as $item) {
                $this->employeeRepository->createEmployee($item);
            }
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Employees created successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function listDummy(Request $request)
    {
        $month = $request->route('month');
        $year  = $request->route('year');

        // Format bulan sekarang (2 digit)
        $bulanNow = str_pad($month, 2, '0', STR_PAD_LEFT);
        $tahunNow = (string) $year;

        // Hitung bulan sebelumnya
        $prevMonth = $month - 1;
        $prevYear  = $year;

        if ($prevMonth === 0) {
            $prevMonth = 12;
            $prevYear  = $year - 1;
        }

        $bulanPrev = str_pad($prevMonth, 2, '0', STR_PAD_LEFT);
        $tahunPrev = (string) $prevYear;

        // Faker dengan lokal Indonesia
        $faker = Faker::create('id_ID');

        // Seed agar konsisten kalau bulan/tahun sama
        $seed = intval($tahunNow . $bulanNow);
        $faker->seed($seed);

        $data = [];
        for ($i = 0; $i < 15; $i++) {
            $fullName = $faker->name();
            $email    = strtolower(str_replace(' ', '_', $fullName)) . $i . "@example.com";

            $data[] = [
                "nip"               => "TK." . str_pad((string)(10000 + $i + 1), 5, "0", STR_PAD_LEFT),
                "nama"              => strtoupper($fullName),
                "npwp"              => $faker->numerify(str_repeat('#', 15)), // 15 digit
                "no_ktp"            => $faker->numerify(str_repeat('#', 16)), // 16 digit
                "kode_green_baru"   => "001",
                "email"             => $email,
                "id_ptkp"           => 1,
                "menikah"           => "f",
                "pegawai_tetap"     => "f",
                "jumlah_tanggungan" => 0,
                "no_rekening"       => $faker->bankAccountNumber(),
                "id_status"         => 2,
                "id_type"           => 2,
                "id_posisi"         => 4,
                "kota"              => $faker->city(),
                "jenis_kelamin"     => 1
            ];
        }

        $response = [
            "success" => true,
            "info" => [
                "bulan_now"  => $bulanNow,
                "tahun_now"  => $tahunNow,
                "bulan_prev" => $bulanPrev,
                "tahun_prev" => $tahunPrev,
                "row_count"  => count($data),
            ],
            "data" => $data
        ];

        return response()->json($response);
    }
}
