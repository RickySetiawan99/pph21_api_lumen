<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Repositories\JournalItemRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

class JournalItemController extends Controller
{
    protected $journalItemRepository;

    public function __construct(JournalItemRepository $journalItemRepository)
    {
        $this->journalItemRepository = $journalItemRepository;
    }

    public function list()
    {
        try {

            $data = $this->journalItemRepository->getAllJournalItem(null, Carbon::now()->format('Y-m-d'));

            $result = Helper::setResults($data);

            return $this->resSuccess(null, $result['res_status'], $result['msg'], $result['status_msg'], $result['result']);
        } catch (\Throwable $th) {

            $error = [
                'error' => $th,
            ];
            return $this->resCatchError($error);
        }
    }

    public function detail($journalItemId)
    {
        try {
            $param = [
                'journal_item_id' => $journalItemId,
            ];

            $data = $this->journalItemRepository->getJournalItem($param);

            $result = Helper::setResults($data);

            return $this->resSuccess($param, $result['res_status'], $result['msg'], $result['status_msg'], $result['result']);
        } catch (\Throwable $th) {

            $error = [
                'error' => $th,
            ];
            return $this->resCatchError($error);
        }
    }

    public function listDummy(Request $request)
    {
        $month = $request->route('month');
        $year  = $request->route('year');

        $tanggalTransaksi = sprintf("%04d-%02d-01", $year, $month);

        $response = [
            "success" => true,
            "info" => [
                "bulan_now" => (string) $month,
                "tahun_now" => (string) $year,
                "row_count" => 10,
            ],
            "data" => [
                [
                    "jenis" => "F0001",
                    "kode_coa" => 53101,
                    "no_rekening" => "4353453",
                    "unit_kerja" => "7",
                    "tipe_id" => 40,
                    "jumlah" => $this->generateJumlah($month, $year, 53101),
                    "tanggal_transaksi" => $tanggalTransaksi
                ],
                [
                    "jenis" => "F0001",
                    "kode_coa" => 53304,
                    "no_rekening" => "4353453",
                    "unit_kerja" => "7",
                    "tipe_id" => 32,
                    "jumlah" => $this->generateJumlah($month, $year, 53304),
                    "tanggal_transaksi" => $tanggalTransaksi
                ],
                [
                    "jenis" => "F0001",
                    "kode_coa" => 53305,
                    "no_rekening" => "4353453",
                    "unit_kerja" => "7",
                    "tipe_id" => 33,
                    "jumlah" => $this->generateJumlah($month, $year, 53305),
                    "tanggal_transaksi" => $tanggalTransaksi
                ],
                [
                    "jenis" => "F0002",
                    "kode_coa" => 53306,
                    "no_rekening" => "4353453",
                    "unit_kerja" => "7",
                    "tipe_id" => 52,
                    "jumlah" => $this->generateJumlah($month, $year, 53306),
                    "tanggal_transaksi" => $tanggalTransaksi
                ],
                [
                    "jenis" => "F0002",
                    "kode_coa" => 56526,
                    "no_rekening" => "4353453",
                    "unit_kerja" => "7",
                    "tipe_id" => 49,
                    "jumlah" => $this->generateJumlah($month, $year, 56526),
                    "tanggal_transaksi" => $tanggalTransaksi
                ],
                [
                    "jenis" => "F0002",
                    "kode_coa" => 53306,
                    "no_rekening" => "4353453",
                    "unit_kerja" => "7",
                    "tipe_id" => 52,
                    "jumlah" => $this->generateJumlah($month, $year, 53306),
                    "tanggal_transaksi" => $tanggalTransaksi
                ],
                [
                    "jenis" => "F0003",
                    "kode_coa" => 56010,
                    "no_rekening" => "4353453",
                    "unit_kerja" => "7",
                    "tipe_id" => 53,
                    "jumlah" => $this->generateJumlah($month, $year, 56010),
                    "tanggal_transaksi" => $tanggalTransaksi
                ],
                [
                    "jenis" => "F0003",
                    "kode_coa" => 54302,
                    "no_rekening" => "4353453",
                    "unit_kerja" => "7",
                    "tipe_id" => 67,
                    "jumlah" => $this->generateJumlah($month, $year, 54302),
                    "tanggal_transaksi" => $tanggalTransaksi
                ],
                [
                    "jenis" => "F0003",
                    "kode_coa" => 54302,
                    "no_rekening" => "4353453",
                    "unit_kerja" => "7",
                    "tipe_id" => 61,
                    "jumlah" => $this->generateJumlah($month, $year, 54302),
                    "tanggal_transaksi" => $tanggalTransaksi
                ],
                [
                    "jenis" => "F0003",
                    "kode_coa" => 54302,
                    "no_rekening" => "4353453",
                    "unit_kerja" => "7",
                    "tipe_id" => 59,
                    "jumlah" => $this->generateJumlah($month, $year, 54302),
                    "tanggal_transaksi" => $tanggalTransaksi
                ],
                [
                    "jenis" => "F0001",
                    "kode_coa" => 53101,
                    "no_rekening" => "4353453",
                    "unit_kerja" => "7",
                    "tipe_id" => 40,
                    "jumlah" => $this->generateJumlah($month, $year, 53101),
                    "tanggal_transaksi" => $tanggalTransaksi
                ],
                [
                    "jenis" => "F0001",
                    "kode_coa" => 53304,
                    "no_rekening" => "4353453",
                    "unit_kerja" => "7",
                    "tipe_id" => 32,
                    "jumlah" => $this->generateJumlah($month, $year, 53304),
                    "tanggal_transaksi" => $tanggalTransaksi
                ],
                [
                    "jenis" => "F0001",
                    "kode_coa" => 53305,
                    "no_rekening" => "4353453",
                    "unit_kerja" => "7",
                    "tipe_id" => 33,
                    "jumlah" => $this->generateJumlah($month, $year, 53305),
                    "tanggal_transaksi" => $tanggalTransaksi
                ],
                [
                    "jenis" => "F0002",
                    "kode_coa" => 53306,
                    "no_rekening" => "4353453",
                    "unit_kerja" => "7",
                    "tipe_id" => 52,
                    "jumlah" => $this->generateJumlah($month, $year, 53306),
                    "tanggal_transaksi" => $tanggalTransaksi
                ],
            ]
        ];

        return response()->json($response);
    }

    public function generateJumlah($month, $year, $kodeCoa)
    {
        // seed tetap agar hasil sama selama month-year sama
        $seed = crc32($month . $year . $kodeCoa);
        mt_srand($seed);

        // generate kelipatan ribuan antara 900k - 20jt
        $random = mt_rand(900, 20000) * 1000;

        return $random;
    }
}
