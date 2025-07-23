@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto bg-white dark:bg-gray-900 p-8 rounded-xl shadow mt-10">
    <h2 class="text-2xl font-bold mb-2 text-gray-800 dark:text-gray-100">LINEチャネル設定</h2>

    @if(session('success'))
      <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
        {{ session('success') }}
      </div>
    @endif

    <form action="{{ route('richmenu.setting.save') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block font-semibold mb-1">チャネル名</label>
            <input type="text" name="channel_name" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 rounded px-3 py-2"
                value="{{ old('channel_name', $setting->channel_name ?? '') }}" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">チャネルアクセストークン</label>
            <input type="text" name="channel_access_token" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 rounded px-3 py-2"
                value="{{ old('channel_access_token', $setting->channel_access_token ?? '') }}" required>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">保存</button>
    </form>
</div>
@endsection
