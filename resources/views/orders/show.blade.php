@extends('layouts.app')

@section('title', 'Order #' . $order->id)

@section('content')
    <h1 class="text-2xl font-bold mb-1">Order #{{ $order->id }}</h1>
    <p class="text-slate-500 mb-6">
        Placed on {{ \Carbon\Carbon::parse($order->date)->format('M j, Y') }}
        &middot; Status: <span class="font-medium capitalize">{{ $order->status }}</span>
    </p>

    <div class="bg-white rounded-xl border border-slate-200 divide-y divide-slate-100 mb-6">
        @foreach ($order->items as $item)
            <div class="flex items-center gap-4 p-4">
                <div class="flex-1">
                    <p class="font-medium">{{ $item->product->name ?? 'Product removed' }}</p>
                    <p class="text-sm text-slate-400">{{ $item->quantity }} &times; ${{ number_format($item->price, 2) }}</p>
                </div>
                <p class="font-medium">${{ number_format($item->quantity * $item->price, 2) }}</p>
            </div>
        @endforeach
    </div>

    <div class="flex justify-end">
        <div class="w-full max-w-xs bg-white rounded-xl border border-slate-200 p-5 flex justify-between text-lg font-semibold">
            <span>Total</span>
            <span>${{ number_format($order->total, 2) }}</span>
        </div>
    </div>
@endsection
