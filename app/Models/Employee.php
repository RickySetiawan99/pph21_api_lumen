<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employees';

    protected $fillable = [
        'employee_no',
        'name',
        'npwp',
        'nik_ktp',
        'current_working_unit_id',
        'email',
        'ptkp_id',
        'is_marriage',
        'is_permanent_employee',
        'jumlah_tanggungan',
        'no_rekening',
        'status_id',
        'type_id',
        'position_id',
        'address',
        'gender',
    ];
}