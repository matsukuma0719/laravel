<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerProfile extends Model
{
    use HasFactory;

    // テーブル名（規約に沿っていれば不要）
    protected $table = 'customer_profile';

    // 複数代入可能なカラム
    protected $fillable = [
        'customer_id',
        'gender',
        'birthday',
        'phone_number',
        'address',
        'mail_address',
        'first_visit_date',
        'last_visit_date',
        'numeber_visit_store',
        'memo',
    ];

    /**
     * 顧客（uuid紐付け）
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }
}
