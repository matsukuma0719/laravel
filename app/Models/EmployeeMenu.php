<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeMenu extends Model
{
    use HasFactory;

    public $table = 'employeemenu'; // ← テーブル名を明示
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'emp_id',
        'menu_id',
        'created_at',
        'updated_at',
    ];
}
