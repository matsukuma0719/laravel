@extends('layouts.app')
@section('content')

<div class="container mx-auto px-4 text-white">
    <h1 class="text-2xl font-bold mb-4">予約一覧</h1>

    @if (session('success'))
        <div class="bg-green-600 border border-green-400 text-white px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- 新規予約ボタンは非表示のまま --}}
    {{--<a href="{{ route('reservations.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded mb-4 inline-block">
        + 新規予約
    </a>--}}

    @forelse ($reservations as $r)
        <div class="bg-gray-800 rounded-lg shadow-md p-4 mb-4">
            <div class="mb-2"><span class="font-semibold">顧客名：</span>{{ $r->customer->name ?? '不明' }}</div>
            <div class="mb-2"><span class="font-semibold">メニュー：</span>{{ $r->menu->menu_name ?? '不明' }}</div>
            <div class="mb-2"><span class="font-semibold">担当者：</span>{{ $r->employee->name ?? '未設定' }}</div>
            <div class="mb-2"><span class="font-semibold">日付：</span>{{ $r->date }}</div>
            <div class="mb-2"><span class="font-semibold">時間：</span>{{ $r->start_time }}〜{{ $r->end_time }}</div>

            {{-- 編集・削除ボタン（コメントアウト状態） --}}
            {{-- 
            <div class="mt-2 space-x-4">
                <a href="{{ route('reservations.edit', $r->id) }}" class="text-blue-400 hover:underline">編集</a>
                <form action="{{ route('reservations.destroy', $r->id) }}" method="POST" class="inline-block" onsubmit="return confirm('削除しますか？')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-400 hover:underline">削除</button>
                </form>
            </div>
            --}}
        </div>
    @empty
        <div class="text-center text-gray-300 py-4">予約データがありません</div>
    @endforelse

    <div class="mt-4">
        {{ $reservations->links() }}
    </div>
</div>

@endsection
