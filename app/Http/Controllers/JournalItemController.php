<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Repositories\JournalItemRepository;
use Carbon\Carbon;

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

    public function listDummy()
    {
        $response = [
            "success" => true,
            "info" => [
                "bulan_now" => "08",
                "tahun_now" => "2025",
                "row_count" => 8408,
            ],
            "data" => [
                [
                    "jenis" => "F0001",
                    "kode_coa" => 53101,
                    "no_rekening" => "2108036276",
                    "unit_kerja" => "172",
                    "tipe_id" => 40,
                    "jumlah" => 523100,
                    "tanggal_transaksi" => "2025-08-01",
                ],
                [
                    "jenis" => "F0001",
                    "kode_coa" => 53101,
                    "no_rekening" => "3109049378",
                    "unit_kerja" => "007",
                    "tipe_id" => 40,
                    "jumlah" => 436500,
                    "tanggal_transaksi" => "2025-08-01",
                ],
                [
                    "jenis" => "F0001",
                    "kode_coa" => 53101,
                    "no_rekening" => "3117000035",
                    "unit_kerja" => "117",
                    "tipe_id" => 40,
                    "jumlah" => 461000,
                    "tanggal_transaksi" => "2025-08-01",
                ],
            ]
        ];

        return response()->json($response);
    }
}
