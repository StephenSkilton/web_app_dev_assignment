@extends('layouts.app')
@section('title', 'New Product')
@section('content')
    <h1 class="text-2xl font-bold mb-6">New Product</h1>
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @include('admin.products._form')
    </form>
@endsection
