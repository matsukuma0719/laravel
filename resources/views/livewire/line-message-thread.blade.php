<!--<div wire:poll.3000ms>
    <div class="h-[500px] overflow-y-scroll bg-white p-4 rounded shadow mb-4">
        @foreach ($chatMessages as $msg) 
            <div class="mb-2 text-sm {{ $msg->is_from_user ? 'text-left' : 'text-right' }}">
                <span class="inline-block px-3 py-2 rounded 
                    {{ $msg->is_from_user ? 'bg-gray-200' : 'bg-green-200' }}">
                    {{ $msg->text }}
                </span>
                <div class="text-xs text-gray-500 mt-1">{{ $msg->sent_at->format('H:i') }}</div>
            </div>
        @endforeach
    </div>

    {{-- ✅ テキスト入力欄 --}}
    <form wire:submit.prevent="sendMessage" class="flex space-x-2">
        <input type="text" wire:model="newMessage" class="flex-1 border rounded px-3 py-2" placeholder="メッセージを入力">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">送信</button>
    </form>
</div>
