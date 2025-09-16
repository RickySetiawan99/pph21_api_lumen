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
}
