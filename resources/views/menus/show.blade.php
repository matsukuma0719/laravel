@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4 dark:text-gray-100">{{ $menu->menu_name }}</h2>
    <p class="dark:text-gray-200">料金：{{ number_format($menu->price) }}円</p>
    <p class="dark:text-gray-200">所要時間：{{ $menu->duration }}分</p>

    @if ($menu->image_url)
        <img src="{{ $menu->image_url }}" alt="{{ $menu->menu_name }}" class="mt-4 w-full h-auto object-cover">
    @endif
</div>
@endsection
