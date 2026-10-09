@extends('layouts.app')
@section('title', 'Edit Order')
@section('content')
    <h1 class="text-2xl font-bold mb-6">Edit Order</h1>
    <form action="{{ route('admin.orders.update', $order) }}" method="POST">
        @include('admin.orders._form')
    </form>
@endsection
