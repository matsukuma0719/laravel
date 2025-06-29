<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- ヘッダー行 -->
            <div class="grid grid-cols-4 gap-4 px-4 py-2 bg-gray-100 dark:bg-gray-700 text-sm font-semibold text-gray-700 dark:text-gray-200 rounded-t">
                <div>顧客名</div>
                <div>メニュー</div>
                <div>日時</div>
                <div>担当者</div>
            </div>

            <!-- 各予約行 -->
@foreach ($reservations as $r)
    <div class="grid grid-cols-4 gap-4 px-4 py-3 border-b border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
        <div class="min-w-0 truncate text-sm">{{ $r->customer->name ?? '不明な顧客' }}</div>
        <div class="min-w-0 truncate text-sm">{{ $r->menu->menu_name ?? '不明なメニュー' }}</div>
        <div class="min-w-0 truncate text-sm">{{ $r->date }} {{ $r->start_time }}〜{{ $r->end_time }}</div>
        <div class="min-w-0 truncate text-sm">{{ $r->employee->name ?? '未設定' }}</div>
    </div>
@endforeach


        </div>
    </div>

    {{-- カスタムCSSがある場合 --}}
    <link rel="stylesheet" href="{{ asset('css/dashboard-cards.css') }}">
</x-app-layout>
