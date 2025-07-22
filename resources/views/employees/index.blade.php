@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-6">従業員一覧</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
        @foreach ($employees as $emp)
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 text-center border border-gray-200 dark:border-gray-500">
                {{-- 丸アイコン：画像 or 頭文字 --}}
               <div class="relative">
    @if ($emp->image_id)
        <img src="{{ asset('storage/employees/' . $emp->image_id) }}"
             alt="{{ $emp->name }}"
             class="w-20 h-20 rounded-full mx-auto object-cover"
             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
    @endif

    {{-- イニシャル表示（常に描画しつつ非表示） --}}
    @php
        $nameParts = explode(' ', $emp->name);
        $initials = strtoupper(
            mb_substr($nameParts[0] ?? '', 0, 1) .
            mb_substr($nameParts[1] ?? '', 0, 1)
        );
    @endphp
    <div class="w-20 h-20 rounded-full bg-gray-300 dark:bg-gray-700 text-white font-bold text-xl flex items-center justify-center mx-auto"
         style="{{ $emp->image_id ? 'display: none;' : '' }}">
        {{ $initials }}
    </div>
</div>

                {{-- 名前 --}}
                <p class="mt-3 text-sm font-semibold text-gray-800 dark:text-gray-200">{{ $emp->name }}</p>
            </div>
        @endforeach
    </div>
</div>
@endsection
