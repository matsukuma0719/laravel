@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6">
    <h2 class="text-xl font-bold mb-6 dark:text-gray-100">メニュー一覧</h2>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
        @foreach ($menus as $menu)
            <a href="{{ route('menus.show', $menu->id) }}"
               class="block bg-white dark:bg-gray-800 border rounded-lg shadow overflow-hidden hover:shadow-lg hover:border-blue-400 transition cursor-pointer">
                {{-- 上半分：画像エリア --}}
                <div class="h-32 bg-gray-200 flex items-center justify-center">
                    @if ($menu->image_url)
                        <img src="{{ $menu->image_url }}" alt="{{ $menu->menu_name }}" class="object-cover w-full h-full">
                    @else
                        <span class="text-gray-400 text-sm">No Image</span>
                    @endif
                </div>

                {{-- 下半分：テキスト --}}
                <div class="p-3 text-center">
                    <div class="font-semibold text-gray-800 dark:text-gray-200">{{ $menu->menu_name }}</div>
                    <div class="text-gray-600 dark:text-gray-300 text-sm">料金：{{ number_format($menu->price) }}円</div>
                    <div class="text-gray-500 dark:text-gray-400 text-sm">所要時間：{{ $menu->duration }}分</div>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endsection
