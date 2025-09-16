<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoryJabatanPegawai extends Model
{
    protected $table = 'employee_historical_positions';

    protected $fillable = [
        'employee_id',
        'tmt_date',
        'jabatan_lama_id',
        'old_working_unit_id',
        'jabatan_baru_id',
        'new_working_unit_id',
        'employee_status_id',
        'employee_type_id',
        'is_generate_last_a1',
    ];
}
