<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Repositories\MutasiRepository;
use Carbon\Carbon;

class MutasiController extends Controller
{
    protected $mutasiRepository;

    public function __construct(MutasiRepository $mutasiRepository)
    {
        $this->mutasiRepository = $mutasiRepository;
    }

    public function list()
    {
        try {

            $data = $this->mutasiRepository->getAllMutasi(null, Carbon::now()->format('Y-m-d'));

            $result = Helper::setResults($data);

            return $this->resSuccess(null, $result['res_status'], $result['msg'], $result['status_msg'], $result['result']);
        } catch (\Throwable $th) {

            $error = [
                'error' => $th,
            ];
            return $this->resCatchError($error);
        }
    }

    public function detail($mutasiId)
    {
        try {
            $param = [
                'mutasi_id' => $mutasiId,
            ];

            $data = $this->mutasiRepository->getMutasi($param);

            $result = Helper::setResults($data);

            return $this->resSuccess($param, $result['res_status'], $result['msg'], $result['status_msg'], $result['result']);
        } catch (\Throwable $th) {

            $error = [
                'error' => $th,
            ];
            return $this->resCatchError($error);
        }
    }

    public function listDummy()
    {
        $response = [
            "success" => true,
            "info" => [
                "bulan_now" => "08",
                "tahun_now" => "2025",
                "bulan_prev" => "07",
                "tahun_prev" => "2025",
                "row_count" => 56,
            ],
            "data" => [
                [
                    "no_rekening" => "3034234578",
                    "unit_kerja_lama" => "001",
                    "unit_kerja_baru" => "001",
                    "terhitung_mulai" => "2025-08-01",
                    "jabatan_lama_id" => 56,
                    "jabatan_baru_id" => 56,
                    "status_id" => 5,
                    "tipe_id" => 1,
                ],
                [
                    "no_rekening" => "3034234459",
                    "unit_kerja_lama" => "001",
                    "unit_kerja_baru" => "001",
                    "terhitung_mulai" => "2025-08-01",
                    "jabatan_lama_id" => 57,
                    "jabatan_baru_id" => 56,
                    "status_id" => 5,
                    "tipe_id" => 1,
                ],
                [
                    "no_rekening" => "2038807257",
                    "unit_kerja_lama" => "001",
                    "unit_kerja_baru" => "001",
                    "terhitung_mulai" => "2025-08-01",
                    "jabatan_lama_id" => 56,
                    "jabatan_baru_id" => 56,
                    "status_id" => 5,
                    "tipe_id" => 1,
                ],
            ]
        ];

        return response()->json($response);
    }
}
