@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-6">予約一覧</h1>

        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2">日付</th>
                        <th class="px-4 py-2">メニュー</th>
                        <th class="px-4 py-2">開始</th>
                        <th class="px-4 py-2">終了</th>
                        <th class="px-4 py-2">顧客名</th>
                        <th class="px-4 py-2">担当者</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reservations as $res)
                        <tr class="border-t">
                            <td class="px-4 py-2 text-center">{{ $res->date }}</td>
                            <td class="px-4 py-2 text-center">{{ $res->menu->menu_name ?? '不明' }}</td>
                            <td class="px-4 py-2 text-center">{{ \Carbon\Carbon::parse($res->start_time)->format('H:i') }}</td>
                            <td class="px-4 py-2 text-center">{{ \Carbon\Carbon::parse($res->end_time)->format('H:i') }}</td>
                            <td class="px-4 py-2 text-center">{{ $res->customer->name ?? '不明' }}</td>
                            <td class="px-4 py-2 text-center">{{ $res->employee->name ?? '不明' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
