@extends('layouts.app')
@section('title', 'Edit Manufacturer')
@section('content')
    <h1 class="text-2xl font-bold mb-6">Edit Manufacturer</h1>
    <form action="{{ route('admin.manufacturers.update', $manufacturer) }}" method="POST">
        @include('admin.manufacturers._form')
    </form>
@endsection
