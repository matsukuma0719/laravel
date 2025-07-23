@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-2">リッチメニュー一覧</h2>
        <a href="{{ route('richmenu.create') }}" class="bg-green-600 dark:bg-green-700 text-white px-4 py-2 rounded hover:bg-green-700 dark:hover:bg-green-600">設定</a>
    </div>

    <div class="overflow-auto bg-white dark:bg-gray-900 rounded-xl shadow mb-10">
        <table class="min-w-full table-auto text-center text-gray-700 dark:text-gray-200 border-collapse">
            <thead class="bg-gray-700 text-gray-200 text-sm">
                <tr>
                    <th class="px-3 py-2 w-16"></th> <!-- 適用ボタン用 -->
                    <th class="px-3 py-2 w-16"></th> <!-- 編集ボタン用 -->
                    <th class="px-4 py-2">タイトル</th>
                    <th class="px-4 py-2">画像</th>
                    <th class="px-4 py-2">適用属性</th>
                </tr>
            </thead>
            <tbody>
                @forelse($menus as $menu)
                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <td class="px-2 py-2 text-center">
                            <form action="{{ route('richmenu.apply', $menu->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition">
                                    適用
                                </button>
                            </form>
                        </td>
                        <td class="px-2 py-2 text-center">
                            <a href="{{ route('richmenu.edit', $menu->id) }}" class="bg-gray-500 text-white px-3 py-1 rounded hover:bg-gray-700 transition">編集</a>
                        </td>
                        <td class="px-4 py-2 text-center">{{ $menu->title }}</td>
                        <td class="px-4 py-2 text-center">
                            @if($menu->image_path)
                                <img src="{{ asset('storage/' . $menu->image_path) }}" alt="" class="w-20 h-12 object-cover rounded">
                            @else
                                <span class="text-gray-400">画像なし</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-xs text-center">
                            <span class="mr-2">
                                <span class="font-semibold">性別:</span>
                                @if(!empty($menu->genders))
                                    {{ implode('・', $menu->genders) }}
                                @else
                                    全て
                                @endif
                            </span>
                            <span>
                                <span class="font-semibold">年代:</span>
                                @if(!empty($menu->ages))
                                    {{ implode('・', array_map(fn($a) => $a.'代', $menu->ages)) }}
                                @else
                                    全て
                                @endif
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-gray-400 py-6">データがありません</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
