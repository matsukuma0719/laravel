<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
