<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    // 主キーがUUIDで、自動増分しない
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    // 複数代入可能なカラム
    protected $fillable = [
        'emp_id',
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
        return $this->belongsToMany(Menu::class, 'employee_menu', 'emp_id', 'menu_id');
    }
}
