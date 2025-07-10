<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workshift extends Model
{
    use HasFactory;

    protected $table = 'work_shifts';
        protected $fillable = [
        'employee_id',
        'work_date',
        'start_time',
        'end_time',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'employee_id');
    }


}

