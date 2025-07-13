@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto p-4">
        <h1 class="text-xl font-semibold mb-4">メッセージ一覧</h1>

        <livewire:line-customer-list />
    </div>
@endsection
