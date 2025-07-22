@extends('layouts.app')
@section('content')

<div class="container mx-auto px-4 py-6 text-white">
    <h1 class="text-2xl font-bold mb-2">予約編集</h1>

    <form action="{{ route('reservations.update', $reservation->id ?? 0) }}" method="POST" class="bg-gray-800 p-6 rounded shadow-md max-w-xl">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="employee" class="block mb-2 font-semibold">担当者</label>
            <input type="text" id="employee" name="emp_name" class="w-full px-3 py-2 bg-gray-700 rounded" value="{{ $employee->name }}" readonly>
        </div>

        <div class="mb-4">
            <label for="time" class="block mb-2 font-semibold">時間</label>
            <input type="text" id="time" name="start_time" class="w-full px-3 py-2 bg-gray-700 rounded" value="{{ $time }}" readonly>
        </div>

        <div class="mb-4">
            <label for="menu_name" class="block mb-2 font-semibold">メニュー名</label>
            <input type="text" id="menu_name" name="menu_name" class="w-full px-3 py-2 bg-gray-700 rounded" value="{{ $reservation->menu_name ?? '' }}">
        </div>

        <div class="mb-4">
            <label for="customer_name" class="block mb-2 font-semibold">顧客名</label>
            <input type="text" id="customer_name" name="customer_name" class="w-full px-3 py-2 bg-gray-700 rounded" value="{{ $reservation->customer_name ?? '' }}">
        </div>

        <div class="text-right">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                更新する
            </button>
        </div>
    </form>
</div>

@endsection
