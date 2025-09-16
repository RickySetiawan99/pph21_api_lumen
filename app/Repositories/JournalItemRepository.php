<?php

namespace App\Repositories;

use App\Helpers\Helper;
use App\Models\HistoryJabatanPegawai;
use App\Models\JournalItem;
use Carbon\Carbon;

class JournalItemRepository
{
    public function getAllJournalItem($workingUnitId = null, $date = null)
    {
        $date = !empty($date) ? Carbon::parse($date)->format('Y-m-d') : Carbon::now()->format('Y-m-d');

        $startOfMonth = Carbon::parse($date)->startOfMonth()->format('Y-m-d');

        $query = JournalItem::query();

        if (!empty($workingUnitId)) {
            $query->where('working_unit_id', $workingUnitId);
        }

        $query->whereBetween('journal_date', [$startOfMonth, $date]);

        $getJournalItem = $query->get();

        $dataJournalItem = $this->dataJournalItem($getJournalItem);

        $result = Helper::setResultsRepository($dataJournalItem);

        return $result;
    }

    public function dataJournalItem($getJournalItem)
    {
        if (count($getJournalItem) > 0) {
            $dataJournalItem = $getJournalItem->map(function ($employee) {
                $array_data = $this->arrayData($employee);
                return $array_data;
            });
        } else {
            $dataJournalItem = [];
        }

        return $dataJournalItem;
    }

    public function getJournalItem($param)
    {
        $workingUnitId = $param['working_unit_id'] ?? null;
        $journalItemId  = $param['journal_item_id'];

        if (!empty($workingUnitId)) {
            $getJournalItem = JournalItem::where('working_unit_id', $workingUnitId)->where('id', $journalItemId)->first();
        } else {
            $getJournalItem = JournalItem::where('id', $journalItemId)->first();
        }

        $dataJournalItem = $this->arrayData($getJournalItem);

        $result = Helper::setResultsRepository($dataJournalItem);

        return $result;
    }

    public function arrayData($getJournalItem)
    {
        if (!empty($getJournalItem)) {
            $dataJournalItem = [
                'id' => $getJournalItem->id,
                'account_id' => $getJournalItem->account_id,
                'amount' => $getJournalItem->amount,
                'journal_date' => $getJournalItem->journal_date,
                'employee_id' => $getJournalItem->employee_id,
                'description' => $getJournalItem->description,
                'name' => $getJournalItem->name,
                'is_facilities' => $getJournalItem->is_facilities,
                'employee_facilities_id' => $getJournalItem->employee_facilities_id,
                'working_unit_id' => $getJournalItem->working_unit_id,
                'no_rekening_other' => $getJournalItem->no_rekening_other,
                'employee_status_id' => $getJournalItem->employee_status_id,
                'employee_type_id' => $getJournalItem->employee_type_id,
            ];
        } else {
            $dataJournalItem = [];
        }

        return $dataJournalItem;
    }
}
