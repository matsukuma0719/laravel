@extends('layouts.app')

@section('content')
<div class="overflow-auto">
    <h2 class="text-xl font-bold mb-4 dark:text-gray-100">勤務シフト一覧</h2>

    <form action="{{ route('work_shifts.bulkUpdate') }}" method="POST">
        @csrf

        <div class="flex justify-end mb-2 space-x-2">
            <button type="button" id="editBtn" class="px-4 py-1 bg-blue-500 text-white rounded">編集</button>
            <button type="submit" id="saveBtn" class="px-4 py-1 bg-green-500 text-white rounded hidden">保存</button>
        </div>

        <div class="flex justify-end mb-2">
            @php
                $prevMonth = $month - 1;
                $prevYear = $year;
                if ($prevMonth < 1) {
                    $prevMonth = 12;
                    $prevYear--;
                }

                $nextMonth = $month + 1;
                $nextYear = $year;
                if ($nextMonth > 12) {
                    $nextMonth = 1;
                    $nextYear++;
                }
            @endphp

            <div class="flex items-center justify-between mb-4">
                <a href="{{ route('work_shifts.index', ['year' => $prevYear, 'month' => $prevMonth]) }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                    {{ $prevMonth }}月
                </a>

                <span class="text-lg font-bold">
                    {{ $year }}年{{ $month }}月
                </span>

                <a href="{{ route('work_shifts.index', ['year' => $nextYear, 'month' => $nextMonth]) }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                    {{ $nextMonth }}月
                </a>
            </div>
        </div>

        <div class="overflow-auto border rounded-lg shadow bg-white dark:bg-gray-800">
            <table class="min-w-full text-sm text-center text-gray-700 dark:text-gray-200 border-collapse">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-200 uppercase text-xs">
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 dark:border-gray-500 px-2 py-1 text-left">従業員名</th>
                        @foreach ($dates as $date)
                            @php $carbonDate = \Carbon\Carbon::parse($date); @endphp
                            <th class="border border-gray-300 dark:border-gray-500 px-2 py-1 whitespace-nowrap text-center">
                                {{ $carbonDate->format('n/j') }}<br>
                                {{ ['日','月','火','水','木','金','土'][$carbonDate->dayOfWeek] }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $employee)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="border border-gray-300 dark:border-gray-500 px-2 py-1 font-semibold whitespace-nowrap dark:text-gray-200">
                                {{ $employee->name }}
                            </td>
                            @foreach ($dates as $date)
                                @php
                                    $dateString = \Carbon\Carbon::parse($date)->toDateString();
                                    $shift = $employee->workshifts->firstWhere('work_date', $dateString);
                                    $value = $shift
                                        ? convertToCode(
                                            \Carbon\Carbon::parse($shift->start_time)->format('H:i:s'),
                                            \Carbon\Carbon::parse($shift->end_time)->format('H:i:s')
                                        )
                                        : '';
                                @endphp
                                <td class="border border-gray-300 dark:border-gray-500 text-center p-0 dark:text-gray-200">
                                    <div class="relative">
                                        <span class="display-span">{{ $value }}</span>
                                        <input type="text"
                                               name="work_shifts [{{ $employee->employee_id }}][{{ $dateString }}]"
                                               value="{{ $value }}"
                                               class="work-input w-full text-center px-0 py-1 border-none focus:outline-none hidden"
                                               style="height: 30px;" />
                                    </div>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </form>
</div>

<script>
    const editBtn = document.getElementById('editBtn');
    const saveBtn = document.getElementById('saveBtn');
    const inputs = document.querySelectorAll('.work-input');
    const spans = document.querySelectorAll('.display-span');

    editBtn.addEventListener('click', () => {
        inputs.forEach(input => input.classList.remove('hidden'));
        spans.forEach(span => span.classList.add('hidden'));
        editBtn.classList.add('hidden');
        saveBtn.classList.remove('hidden');
    });
</script>
@endsection
