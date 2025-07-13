<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LineMessage extends Model
{
    protected $table = 'messages';

    // ✅ 保存可能なカラム
    protected $fillable = [
        'user_id',
        'text',
        'is_from_user',
        'sent_at',
    ];

    // ✅ sent_atをCarbonインスタンスに
    protected $casts = [
        'sent_at' => 'datetime',
    ];

    // 顧客とのリレーション（任意：顧客一覧などで使う）
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'user_id', 'user_id');
    }
}
