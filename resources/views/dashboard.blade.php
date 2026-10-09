@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Dashboard</h1>

    <div class="bg-white rounded-xl border border-slate-200 p-6">
        {{ __("You're logged in!") }}
    </div>
@endsection
