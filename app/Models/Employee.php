<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    // 複数代入可能なカラム
    protected $fillable = [
        'employee_id',
        'name',
        'user_id',
        'image_id',
        'bio',
        'menu_id',
        'role',
    ];

    /**
     * この従業員が対応できるメニュー一覧（多対多）
     */
    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'employeemenu', 'employee_id', 'menu_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'employee_id');
    }

public function workShifts()
{
    // 第2: work_shifts側のキー, 第3: employees側のキー
    return $this->hasMany(\App\Models\WorkShift::class, 'employee_id', 'employee_id');
}
}
