@extends('layouts.app')
@section('title', 'New Order')
@section('content')
    <h1 class="text-2xl font-bold mb-6">New Order</h1>
    <form action="{{ route('admin.orders.store') }}" method="POST">
        @include('admin.orders._form')
    </form>
@endsection
