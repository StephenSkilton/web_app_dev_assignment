@extends('layouts.app')
@section('title', 'New Cart')
@section('content')
    <h1 class="text-2xl font-bold mb-6">New Cart</h1>
    <form action="{{ route('admin.carts.store') }}" method="POST">
        @include('admin.carts._form')
    </form>
@endsection
