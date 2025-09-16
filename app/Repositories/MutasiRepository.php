<?php

namespace App\Repositories;

use App\Helpers\Helper;
use App\Models\HistoryJabatanPegawai;
use Carbon\Carbon;

class MutasiRepository
{
    public function getAllMutasi($workingUnitId = null, $date = null)
    {
        $date = !empty($date) ? Carbon::parse($date)->format('Y-m-d') : Carbon::now()->format('Y-m-d');

        $startOfMonth = Carbon::parse($date)->startOfMonth()->format('Y-m-d');
        
        $query = HistoryJabatanPegawai::query();

        if (!empty($workingUnitId)) {
            $query->where('new_working_unit_id', $workingUnitId);
        }

        $query->whereBetween('tmt_date', [$startOfMonth, $date]);

        $getMutasi = $query->get();

        $dataMutasi = $this->dataMutasi($getMutasi);

        $result = Helper::setResultsRepository($dataMutasi);

        return $result;
    }

    public function dataMutasi($getMutasi)
    {
        if (count($getMutasi) > 0) {
            $dataMutasi = $getMutasi->map(function ($employee) {
                $array_data = $this->arrayData($employee);
                return $array_data;
            });
        } else {
            $dataMutasi = [];
        }

        return $dataMutasi;
    }

    public function getMutasi($param)
    {
        $workingUnitId = $param['new_working_unit_id'] ?? null;
        $mutasiId  = $param['mutasi_id'];

        if (!empty($workingUnitId)) {
            $getMutasi = HistoryJabatanPegawai::where('new_working_unit_id', $workingUnitId)->where('id', $mutasiId)->first();
        } else {
            $getMutasi = HistoryJabatanPegawai::where('id', $mutasiId)->first();
        }

        $dataMutasi = $this->arrayData($getMutasi);

        $result = Helper::setResultsRepository($dataMutasi);

        return $result;
    }

    public function arrayData($getMutasi)
    {
        if (!empty($getMutasi)) {
            $dataMutasi = [
                'id' => $getMutasi->id,
                'employee_id' => $getMutasi->employee_id,
                'tmt_date' => $getMutasi->tmt_date,
                'jabatan_lama_id' => $getMutasi->jabatan_lama_id,
                'old_working_unit_id' => $getMutasi->old_working_unit_id,
                'jabatan_baru_id' => $getMutasi->jabatan_baru_id,
                'new_working_unit_id' => $getMutasi->new_working_unit_id,
                'employee_status_id' => $getMutasi->employee_status_id,
                'employee_type_id' => $getMutasi->employee_type_id,
                'is_generate_last_a1' => $getMutasi->is_generate_last_a1,
            ];
        } else {
            $dataMutasi = [];
        }

        return $dataMutasi;
    }
}
