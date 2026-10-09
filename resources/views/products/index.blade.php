@extends('layouts.app')

@section('title', 'Shop')

@section('content')
    <h1 class="text-2xl font-bold mb-6">All Products</h1>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse ($products as $product)
            @include('products._card', ['product' => $product])
        @empty
            <p class="text-slate-500 col-span-full">No products yet.</p>
        @endforelse
    </div>
@endsection
