@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-7xl mx-auto">
        <div id="nowTime"></div>
        <h3 class="text-lg font-bold mb-2">本日の予約スケジュール</h3>
        <div class="overflow-auto border rounded-lg shadow bg-white">
            <table class="min-w-full text-xs text-center text-gray-700 border-collapse">
                <thead class="bg-gray-100 text-gray-600 uppercase text-[13px]">
                    <tr>
                        <th class="px-1 py-1 border">従業員</th>
                        @foreach ($timeSlots as $time)
                            <th class="px-1 py-1 border">{{ $time }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $employee)
                        <tr class="hover:bg-gray-50">
                            <td class="px-1 py-1 border text-left text-[13px] whitespace-nowrap">
                                {{ $employee->name }}
                            </td>
                            @foreach ($timeSlots as $time)
                                @php
                                    $rsv = $reservations->first(function($r) use ($employee, $time) {
                                        return $r->employee_id === $employee->employee_id &&
                                               $r->start_time <= $time &&
                                               $r->end_time > $time;
                                    });
                                @endphp
                                <td class="px-1 py-1 border text-[13px] {{ $rsv ? 'bg-blue-100 text-blue-900 font-semibold' : '' }}">
                                    {{ $rsv->menu->menu_name ?? '' }}
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
         <div class="mb-8">
        <h3 class="text-lg font-bold mb-2">本日の直近予約5件</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full text-xs border">
                <thead class="bg-gray-100 text-gray-600 uppercase">
                    <tr>
                        <th class="px-2 py-2 border">時間</th>
                        <th class="px-2 py-2 border">顧客名</th>
                        <th class="px-2 py-2 border">メニュー</th>
                        <th class="px-2 py-2 border">担当者</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recentReservations as $r)
                        <tr>
                            <td class="border px-2 py-1">{{ $r->start_time }}〜{{ $r->end_time }}</td>
                            <td class="border px-2 py-1">{{ $r->customer->name ?? '' }}</td>
                            <td class="border px-2 py-1">{{ $r->menu->menu_name ?? '' }}</td>
                            <td class="border px-2 py-1">{{ $r->employee->name ?? '' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- ▼ 本日の出勤予定者をカード型で表示 --}}
    <div class="mb-8">
        <h3 class="text-lg font-bold mb-2">本日の出勤スタッフ</h3>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
            @foreach ($workEmployees as $emp)
                <div class="bg-white shadow rounded-lg p-3 flex flex-col items-center border">
                    {{-- 画像表示（なければイニシャル円） --}}
                    @if($emp->image_id)
                        <img src="{{ asset('storage/' . $emp->image_id) }}" class="w-12 h-12 rounded-full mb-2 object-cover" alt="スタッフ画像">
                    @else
                        <div class="w-12 h-12 rounded-full bg-gray-300 flex items-center justify-center text-lg font-bold mb-2 text-gray-700">
                            {{ mb_substr($emp->name, 0, 1) }}
                        </div>
                    @endif
                    <div class="font-semibold">{{ $emp->name }}</div>
                    <div class="text-xs text-gray-500">{{ $emp->role }}</div>
                </div>
            @endforeach
        </div>
    </div>
    </div>
</div>
@endsection

<script>
function updateTime() {
    const now = new Date();
    const y = now.getFullYear();
    const m = String(now.getMonth() + 1).padStart(2, '0');
    const d = String(now.getDate()).padStart(2, '0');
    const h = String(now.getHours()).padStart(2, '0');
    const i = String(now.getMinutes()).padStart(2, '0');
    const s = String(now.getSeconds()).padStart(2, '0');
    document.getElementById('nowTime').innerHTML =
        `${y}-${m}-${d}<br>${h}:${i}:${s}`;
}
setInterval(updateTime, 1000);
updateTime();
</script>