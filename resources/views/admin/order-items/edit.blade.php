@extends('layouts.app')
@section('title', 'Edit Order Item')
@section('content')
    <h1 class="text-2xl font-bold mb-6">Edit Order Item</h1>
    <form action="{{ route('admin.order-items.update', $orderItem) }}" method="POST">
        @include('admin.order-items._form')
    </form>
@endsection
