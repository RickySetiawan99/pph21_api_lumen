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
}
