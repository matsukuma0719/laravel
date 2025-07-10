<?php

use Carbon\Carbon;

function convertCodeToTime($code)
{
    $code = str_replace('-', '', $code); // ← ✅ ここを追加

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


if (!function_exists('convertToCode')) {
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
                $duration = $end->diffInHours($start);
                return $code . $duration;
            }
        }

        return null; // 対応するコードがない場合
    }
}
