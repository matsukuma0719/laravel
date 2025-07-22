@extends('layouts.app')

@section('content')
<div x-data="{ showModal: false, modalData: {} }" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">本日の予約スケジュール</h2>

    <div class="overflow-auto border rounded-lg shadow bg-white dark:bg-gray-800">
        <table class="min-w-full text-sm text-center text-gray-700 dark:text-gray-200 border-collapse">
            <thead class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-200 uppercase text-xs">
                <tr>
                    <th class="px-3 py-2 border border-gray-300 dark:border-gray-500">従業員</th>
                    @foreach ($timeSlots as $time)
                        <th class="px-3 py-2 border border-gray-300 dark:border-gray-500">{{ $time }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $employee)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-3 py-2 font-semibold border border-gray-300 dark:border-gray-500 dark:text-gray-200">{{ $employee->name }}</td>
                        @foreach ($timeSlots as $time)
                            @php
                                $rsv = $reservations->first(function($r) use ($employee, $time) {
                                    return $r->employee_id === $employee->employee_id &&
                                           $r->start_time <= $time &&
                                           $r->end_time > $time;
                                });
                            @endphp
                            <td
                                class="px-2 py-2 border border-gray-300 dark:border-gray-500 cursor-pointer {{ $rsv ? 'bg-blue-100 dark:bg-blue-900 text-blue-900 dark:text-blue-100 font-medium' : '' }} dark:text-gray-200"
                                @if ($rsv)
                                    @click="showModal = true; modalData = {
                                        employee: '{{ $employee->name }}',
                                        menu: '{{ $rsv->menu->menu_name }}',
                                        start: '{{ $rsv->start_time }}',
                                        end: '{{ $rsv->end_time }}',
                                        date: '{{ $rsv->date }}'
                                    }"
                                @endif
                            >
                                {{ $rsv->menu->menu_name ?? '' }}
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- モーダル -->
    <div
        x-show="showModal"
        class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50"
        style="display: none;"
    >
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-lg font-bold mb-4 text-gray-800 dark:text-gray-100">予約詳細</h2>
            <p><strong>従業員:</strong> <span x-text="modalData.employee"></span></p>
            <p><strong>メニュー:</strong> <span x-text="modalData.menu"></span></p>
            <p><strong>日付:</strong> <span x-text="modalData.date"></span></p>
            <p><strong>時間:</strong> <span x-text="modalData.start + ' 〜 ' + modalData.end"></span></p>
            <div class="text-right mt-4">
                <button @click="showModal = false" class="px-4 py-1 bg-gray-200 rounded hover:bg-gray-300">
                    閉じる
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
