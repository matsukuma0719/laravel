//<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\LineMessage;
use App\Models\Customer;
use Carbon\Carbon;

class LineMessageThread extends Component
{
    public $customer_id;
    public $chatMessages = [];
    public $newMessage = ''; // 入力中のメッセージ

    public function mount($customer_id)
    {
        $this->customer_id = $customer_id;
        $this->loadMessages();
    }

    public function loadMessages()
    {
        $customer = Customer::findOrFail($this->customer_id);

        $this->chatMessages = LineMessage::where('user_id', $customer->user_id)
                                         ->orderBy('sent_at')
                                         ->get();
    }

    public function sendMessage()
    {
        $this->validate([
            'newMessage' => 'required|string|max:1000',
        ]);

        $customer = Customer::findOrFail($this->customer_id);

        // DBに保存（送信者：自分）
        LineMessage::create([
            'user_id'      => $customer->user_id,
            'text'         => $this->newMessage,
            'is_from_user' => 1,
            'sent_at'      => now(),
        ]);

        $this->newMessage = '';
        $this->loadMessages(); // 表示を更新
    }

public function render()
{
    $this->loadMessages(); // chatMessagesを更新
    return view('livewire.line-message-thread'); // ← chatMessagesはそのまま使える
}

}
