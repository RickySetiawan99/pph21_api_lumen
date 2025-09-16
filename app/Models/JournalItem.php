<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JournalItem extends Model
{
    protected $table = 'journal_items';

    protected $fillable = [
        'account_id',
        'amount',
        'journal_date',
        'employee_id',
        'description',
        'name',
        'is_facilities',
        'employee_facilities_id',
        'working_unit_id',
        'no_rekening_other',
        'employee_status_id',
        'employee_type_id',
    ];
}
