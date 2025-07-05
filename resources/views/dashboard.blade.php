<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
<div class="bg-red-500 text-white p-4 font-bold">Tailwind CSSテスト：赤背景なら成功！</div>
<link rel="stylesheet" href="{{ asset('css/output.css') }}">

                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600 text-sm">
                    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                        <tr>
                            <th class="px-4 py-2 text-left">顧客名</th>
                            <th class="px-4 py-2 text-left">メニュー</th>
                            <th class="px-4 py-2 text-left">日時</th>
                            <th class="px-4 py-2 text-left">担当者</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
                        @foreach ($reservations as $r)
                            <tr>
                                <td class="px-4 py-2">{{ $r->customer->name ?? '不明な顧客' }}</td>
                                <td class="px-4 py-2">{{ $r->menu->menu_name ?? '不明なメニュー' }}</td>
                                <td class="px-4 py-2">{{ $r->date }} {{ $r->start_time }}〜{{ $r->end_time }}</td>
                                <td class="px-4 py-2">{{ $r->employee->name ?? '未設定' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>
