@extends('layouts.app')
@section('title', 'Edit Cart Item')
@section('content')
    <h1 class="text-2xl font-bold mb-6">Edit Cart Item</h1>
    <form action="{{ route('admin.cart-items.update', $cartItem) }}" method="POST">
        @include('admin.cart-items._form')
    </form>
@endsection
