@extends('layouts.app')
@section('title', 'New Manufacturer')
@section('content')
    <h1 class="text-2xl font-bold mb-6">New Manufacturer</h1>
    <form action="{{ route('admin.manufacturers.store') }}" method="POST">
        @include('admin.manufacturers._form')
    </form>
@endsection
