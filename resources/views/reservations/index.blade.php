@extends('layouts.app') {{-- Laravel Breeze や UI Kit 使用時 --}}
@section('content')

<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">予約一覧</h1>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!--<a href="{{ route('reservations.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded mb-4 inline-block">
        + 新規予約
    </a>
-->

    <div class="overflow-x-auto">
        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2">顧客名</th>
                    <th class="border px-4 py-2">メニュー</th>
                    <th class="border px-4 py-2">担当者</th>
                    <th class="border px-4 py-2">日付</th>
                    <th class="border px-4 py-2">時間</th>
                    <th class="border px-4 py-2">操作</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reservations as $r)
                    <tr>
                        <td class="border px-4 py-2">{{ $r->customer->name ?? '不明' }}</td>
                        <td class="border px-4 py-2">{{ $r->menu->menu_name ?? '不明' }}</td>
                        <td class="border px-4 py-2">{{ $r->employee->name ?? '未設定' }}</td>
                        <td class="border px-4 py-2">{{ $r->date }}</td>
                        <td class="border px-4 py-2">{{ $r->start_time }}〜{{ $r->end_time }}</td>
                        <td class="border px-4 py-2 space-x-2">
                            <a href="{{ route('reservations.edit', $r->id) }}" class="text-blue-600 hover:underline">編集</a>

                            <form action="{{ route('reservations.destroy', $r->id) }}" method="POST" class="inline-block" onsubmit="return confirm('削除しますか？')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">削除</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">予約データがありません</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $reservations->links() }} {{-- ページネーション --}}
    </div>
</div>

@endsection
