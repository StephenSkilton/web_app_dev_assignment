@extends('layouts.app')
@section('title', 'Edit Cart')
@section('content')
    <h1 class="text-2xl font-bold mb-6">Edit Cart</h1>
    <form action="{{ route('admin.carts.update', $cart) }}" method="POST">
        @include('admin.carts._form')
    </form>
@endsection
