@extends('layouts.app')

@section('title', 'Your Cart')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Your Cart</h1>

    @if ($cart->items->isEmpty())
        <p class="text-slate-500">Your cart is empty. <a href="{{ route('products.index') }}" class="text-indigo-600 hover:underline">Browse products</a>.</p>
    @else
        <div class="bg-white rounded-xl border border-slate-200 divide-y divide-slate-100">
            @foreach ($cart->items as $item)
                <div class="flex items-center gap-4 p-4">
                    <div class="w-16 h-16 bg-slate-100 rounded-lg flex-shrink-0"></div>

                    <div class="flex-1">
                        <p class="font-medium">{{ $item->product->name }}</p>
                        <p class="text-sm text-slate-400">${{ number_format($item->product->price, 2) }} each</p>
                    </div>

                    <form action="{{ route('cart.items.update', $item) }}" method="POST" class="flex items-center gap-2">
                        @csrf
                        @method('PUT')
                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="w-16 rounded-lg border-slate-300 text-sm">
                        <button type="submit" class="text-sm text-indigo-600 hover:underline">Update</button>
                    </form>

                    <p class="w-24 text-right font-medium">${{ number_format($item->quantity * $item->product->price, 2) }}</p>

                    <form action="{{ route('cart.items.destroy', $item) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-sm text-red-500 hover:underline">Remove</button>
                    </form>
                </div>
            @endforeach
        </div>

        <div class="mt-6 flex justify-end">
            <div class="w-full max-w-xs bg-white rounded-xl border border-slate-200 p-5">
                <div class="flex justify-between text-lg font-semibold mb-4">
                    <span>Total</span>
                    <span>${{ number_format($cart->items->sum(fn($i) => $i->quantity * $i->product->price), 2) }}</span>
                </div>
                <form action="{{ route('cart.checkout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-indigo-600 text-white py-2.5 rounded-lg font-medium hover:bg-indigo-700">
                        Checkout
                    </button>
                </form>
            </div>
        </div>
    @endif
@endsection
