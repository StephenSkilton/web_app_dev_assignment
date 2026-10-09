@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
    <h1 class="text-2xl font-bold mb-6">My Orders</h1>

    @if ($orders->isEmpty())
        <p class="text-slate-500">You haven't placed any orders yet. <a href="{{ route('products.index') }}" class="text-indigo-600 hover:underline">Browse products</a>.</p>
    @else
        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-left text-slate-500">
                    <tr>
                        <th class="px-4 py-3">Order</th>
                        <th class="px-4 py-3">Date</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Total</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($orders as $order)
                        <tr>
                            <td class="px-4 py-3 font-medium">#{{ $order->id }}</td>
                            <td class="px-4 py-3 text-slate-500">{{ \Carbon\Carbon::parse($order->date)->format('M j, Y') }}</td>
                            <td class="px-4 py-3"><span class="capitalize">{{ $order->status }}</span></td>
                            <td class="px-4 py-3">${{ number_format($order->total, 2) }}</td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('orders.show', $order) }}" class="text-indigo-600 hover:underline">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection
