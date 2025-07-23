<!--<div wire:poll.10s>
    <h2 class="text-xl font-bold mb-2">やり取りのあるお客様一覧</h2>

    <ul class="space-y-2">
    @foreach ($customers as $customer)
        <li class="bg-white p-4 rounded shadow hover:bg-gray-100 transition">
            @if ($customer->customer_id)
                <a href="{{ route('line.messages.index', ['customer_id' => $customer->customer_id]) }}" class="block">
                    <div class="font-bold text-lg text-blue-700">
                        {{ $customer->name ?? '（名前未設定）' }}
                    </div>
                    <div class="text-sm text-gray-500">
                        {{ $customer->latestMessage->text ?? '（最新メッセージなし）' }}
                    </div>
                </a>
            @else
                <div class="text-gray-400">UUID未設定</div>
            @endif
        </li>
    @endforeach
</ul>

</div>
