<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\LineMessage;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_id',
        'name',
        'phone_number',
        'employee_id',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'customer_id', 'customer_id');
    }

    // app/Models/Customer.php
    public function latestReservation()
    {
        return $this->hasOne(\App\Models\Reservation::class, 'customer_id', 'customer_id')->latestOfMany('date');
    }

    public function messages()
    {
        return $this->hasMany(\App\Models\LineMessage::class, 'user_id', 'user_id');
    }


    public function latestMessage()
    {
        return $this->hasOne(\App\Models\LineMessage::class, 'user_id', 'user_id')->latestOfMany('sent_at');
    }

    
    public function profile()
    {
        return $this->hasOne(CustomerProfile::class, 'customer_id', 'customer_id');
    }

    // app/Models/Customer.php

    protected static function booted()
    {
        static::created(function ($customer) {
            // CustomerProfileの自動作成
            \App\Models\CustomerProfile::create([
                'customer_id' => $customer->customer_id,
                // 他の初期値もここでセット可
            ]);
        });
    }



}
