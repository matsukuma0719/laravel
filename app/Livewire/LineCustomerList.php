<!--<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Customer;

class LineCustomerList extends Component
{
    public function render()
    {
        $customers = Customer::with('latestMessage')
            ->whereNotNull('customer_id')
            ->whereHas('messages')
            ->orderBy('name')
            ->get();

        return view('livewire.line-customer-list', compact('customers'));
    }
}
