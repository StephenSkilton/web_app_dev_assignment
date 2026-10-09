@extends('layouts.app')
@section('title', 'New Cart Item')
@section('content')
    <h1 class="text-2xl font-bold mb-6">New Cart Item</h1>
    <form action="{{ route('admin.cart-items.store') }}" method="POST">
        @include('admin.cart-items._form')
    </form>
@endsection
