@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-6 dark:text-gray-100">予約一覧</h1>

        <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 text-gray-700 dark:text-gray-200">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-200">
                    <tr>
                        <th class="px-4 py-2 border border-gray-300 dark:border-gray-500">日付</th>
                        <th class="px-4 py-2 border border-gray-300 dark:border-gray-500">メニュー</th>
                        <th class="px-4 py-2 border border-gray-300 dark:border-gray-500">開始</th>
                        <th class="px-4 py-2 border border-gray-300 dark:border-gray-500">終了</th>
                        <th class="px-4 py-2 border border-gray-300 dark:border-gray-500">顧客名</th>
                        <th class="px-4 py-2 border border-gray-300 dark:border-gray-500">担当者</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reservations as $res)
                    <tr class="border-t border-gray-300 dark:border-gray-500 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-4 py-2 text-center border border-gray-300 dark:border-gray-500 dark:text-gray-200">{{ $res->date }}</td>
                            <td class="px-4 py-2 text-center border border-gray-300 dark:border-gray-500 dark:text-gray-200">{{ $res->menu->menu_name ?? '不明' }}</td>
                            <td class="px-4 py-2 text-center border border-gray-300 dark:border-gray-500 dark:text-gray-200">{{ \Carbon\Carbon::parse($res->start_time)->format('H:i') }}</td>
                            <td class="px-4 py-2 text-center border border-gray-300 dark:border-gray-500 dark:text-gray-200">{{ \Carbon\Carbon::parse($res->end_time)->format('H:i') }}</td>
                            <td class="px-4 py-2 text-center border border-gray-300 dark:border-gray-500 dark:text-gray-200">{{ $res->customer->name ?? '不明' }}</td>
                            <td class="px-4 py-2 text-center border border-gray-300 dark:border-gray-500 dark:text-gray-200">{{ $res->employee->name ?? '不明' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
