@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <a href="{{ route('products.index') }}" class="text-sm text-indigo-600 hover:underline">&larr; Back to shop</a>

    <div class="mt-4 grid md:grid-cols-2 gap-10">
        <div class="aspect-square bg-slate-100 rounded-xl flex items-center justify-center text-slate-300 overflow-hidden">
            @if ($product->image_url)
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
            @else
                <span>No image</span>
            @endif
        </div>

        <div>
            <p class="text-sm text-slate-400 mb-1">{{ $product->manufacturer->name ?? 'Unbranded' }}</p>
            <h1 class="text-2xl font-bold mb-2">{{ $product->name }}</h1>
            <p class="text-sm text-slate-400 mb-4">SKU: {{ $product->sku }}</p>
            <p class="text-3xl font-semibold mb-6">${{ number_format($product->price, 2) }}</p>
            <p class="text-sm text-slate-400 mb-4">description: {{ $product->description }}</p>

            <form action="{{ route('cart.add') }}" method="POST" class="flex items-center gap-4">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="number" name="quantity" value="1" min="1" class="w-20 rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2.5 rounded-lg font-medium hover:bg-indigo-700">
                    Add to Cart
                </button>
            </form>
        </div>
    </div>
@endsection
