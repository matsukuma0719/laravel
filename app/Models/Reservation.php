<?php

namespace App\Models;
use App\Models\Menu;
use App\Models\Employee;
use App\Models\Customer;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $table = 'reservations';

    protected $primaryKey = 'id';

    public $incrementing = false; // UUIDの場合はfalse

    protected $keyType = 'string';

    protected $fillable = [
        'id', 'reservation_id', 'emp_id', 'menu_id', 'customer_id',
        'date', 'start_time', 'end_time',
    ];
    public function menu()
{
    return $this->belongsTo(Menu::class, 'menu_id');
}

public function employee()
{
    return $this->belongsTo(Employee::class, 'emp_id');
}

public function customer()
{
    return $this->belongsTo(Customer::class, 'customer_id');
}

}
