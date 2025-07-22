@extends('layouts.app')

@section('content')
<div x-data="{ showModal: false, modalData: {} }" class="max-w-5xl mx-auto py-8 px-4">
    <h2 class="text-xl font-bold mb-6 text-gray-800 dark:text-gray-100">顧客一覧</h2>

    <div class="overflow-auto border rounded-lg bg-white dark:bg-gray-800 shadow">
        <table class="min-w-full text-sm text-left text-gray-700 dark:text-gray-300 border-collapse">
            <thead class="bg-gray-100 dark:bg-gray-700 uppercase text-xs text-gray-600 dark:text-gray-300">
                <tr>
                    <th class="px-4 py-2 border">名前</th>
                    <th class="px-4 py-2 border">最終利用日</th>
                    <th class="px-4 py-2 border">電話番号</th>
                    <th class="px-4 py-2 border">登録日</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $customer)
                    <tr class="hover:bg-blue-50 dark:hover:bg-gray-700 cursor-pointer"
                        @click="showModal = true; modalData = {
                            customer_id: '{{ $customer->customer_id }}',
                            name: '{{ $customer->name }}',
                            latest_date: '{{ $customer->latestReservation?->date ?? '—' }}',
                            phone: '{{ $customer->phone_number }}',
                            created: '{{ $customer->created_at->format('Y-m-d H:i') }}'
                        }">
                        <td class="px-4 py-2 border">{{ $customer->name }}</td>
                        <td class="px-4 py-2 border">{{ $customer->latestReservation?->date ?? '—' }}</td>
                        <td class="px-4 py-2 border">{{ $customer->phone_number }}</td>
                        <td class="px-4 py-2 border">{{ $customer->created_at->format('Y-m-d') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- モーダル -->
    <div x-show="showModal" class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50" style="display: none;">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-lg font-bold mb-4 text-gray-800 dark:text-gray-100">顧客詳細</h2>
            <p><strong>名前:</strong> <span x-text="modalData.name"></span></p>
            <p><strong>最終利用日:</strong> <span x-text="modalData.latest_date"></span></p>
            <p><strong>電話番号:</strong> <span x-text="modalData.phone"></span></p>
            <p><strong>登録日時:</strong> <span x-text="modalData.created"></span></p>
            <div class="text-right mt-4">
                <button @click="showModal = false; window.location.href = '/customers/' + modalData.customer_id + '/edit'"
                        class="px-4 py-1 bg-green-200 rounded hover:bg-green-300 mr-2">
                    編集
                </button>
                <button @click="showModal = false" class="px-4 py-1 bg-gray-200 rounded hover:bg-gray-300">
                    閉じる
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
