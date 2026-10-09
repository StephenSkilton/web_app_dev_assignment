@extends('layouts.app')
@section('title', 'New Order Item')
@section('content')
    <h1 class="text-2xl font-bold mb-6">New Order Item</h1>
    <form action="{{ route('admin.order-items.store') }}" method="POST">
        @include('admin.order-items._form')
    </form>
@endsection
