<?php

use Carbon\Carbon;

function convertCodeToTime($code)
{
    $map = [
        'A' => '09:00:00',
        'B' => '10:00:00',
        'C' => '11:00:00',
        'D' => '12:00:00',
        'E' => '13:00:00',
        'F' => '14:00:00',
        'G' => '15:00:00',
    ];

    $letter = strtoupper(substr($code, 0, 1));
    $duration = (int)substr($code, 1);

    if (!isset($map[$letter])) {
        return ['00:00:00', '00:00:00'];
    }

    $startTime = $map[$letter];
    $start = Carbon::createFromFormat('H:i:s', $startTime);
    $end = $start->copy()->addHours($duration);

    return [$startTime, $end->format('H:i:s')];
}

function convertToCode($startTime, $endTime)
{
    $map = [
        'A' => '09:00:00',
        'B' => '10:00:00',
        'C' => '11:00:00',
        'D' => '12:00:00',
        'E' => '13:00:00',
        'F' => '14:00:00',
        'G' => '15:00:00',
    ];

    $start = Carbon::createFromFormat('H:i:s', $startTime);
    $end = Carbon::createFromFormat('H:i:s', $endTime);

    foreach ($map as $code => $time) {
        $mapStart = Carbon::createFromFormat('H:i:s', $time);
        if ($start->equalTo($mapStart)) {
            $duration = abs($end->diffInHours($start)); // 🔧 ← 修正ここ！
            $result = $code . $duration;
            \Log::debug("convertToCode: $startTime ~ $endTime => $result");
            return $result;
        }
    }

    return null;
}
