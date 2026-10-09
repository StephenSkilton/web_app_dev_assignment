@extends('layouts.app')
@section('title', 'Edit Product')
@section('content')
    <h1 class="text-2xl font-bold mb-6">Edit Product</h1>
    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @include('admin.products._form')
    </form>
@endsection
