<!-- resources/views/line/message_thread.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        @livewire('line-message-thread', ['customer_id' => $customer_id])
    </div>
@endsection
