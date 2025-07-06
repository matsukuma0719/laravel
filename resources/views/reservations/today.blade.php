@extends('layouts.app')
@section('content')

<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-white mb-4">本日の予約状況</h1>

    <div class="mb-4 text-right">
        <a href="{{ route('reservations.view-setting') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
            表示設定
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="table-auto border-collapse w-full text-sm text-white">
            <thead>
                <tr class="bg-gray-700">
                    <th class="border px-4 py-2">従業員</th>
                    @for ($i = $startHour; $i <= $endHour; $i++)
                        <th class="border px-4 py-2">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:00</th>
                    @endfor
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $employee)
                    <tr class="bg-gray-800">
                        <td class="border px-2 py-2 font-semibold">{{ $employee->name }}</td>
                        @for ($i = $startHour; $i <= $endHour; $i++)
                            @php
                                $time = str_pad($i, 2, '0', STR_PAD_LEFT) . ':00';
                                $slotKey = $employee->id . '_' . $time;
                                $reservation = $reservations[$slotKey] ?? null;
                            @endphp
                            <td class="border px-2 py-2">
                                <div class="w-full h-10 cursor-pointer rounded {{ $reservation ? 'bg-red-700 text-white font-bold' : 'bg-gray-600' }} editable-slot"
                                     data-emp="{{ $employee->id }}"
                                     data-time="{{ $time }}">
                                    {{ $reservation->menu_name ?? '' }}
                                </div>
                            </td>
                        @endfor
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const slots = document.querySelectorAll('.editable-slot');

        slots.forEach(slot => {
            slot.addEventListener('click', function () {
                const empId = this.dataset.emp;
                const time = this.dataset.time;

                if (confirm("このセルを一時的にロックし、手入力中は外部からの入力をブロックします。LINEからの予約も受け付けなくなりますが、続行しますか？")) {
                    window.location.href = `/reservations/${empId}/edit?time=${encodeURIComponent(time)}`;
                }
            });
        });
    });
</script>

@endsection
