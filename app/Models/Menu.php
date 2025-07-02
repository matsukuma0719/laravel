<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_name',
        'duration',
        'price',
    ];

    /**
     * このメニューに対応する従業員一覧
     */
    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_menu', 'menu_id', 'emp_id');
    }
}
