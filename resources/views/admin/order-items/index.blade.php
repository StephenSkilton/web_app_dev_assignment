@extends('layouts.app')
@section('title', 'Order Items')
@section('content')
    <h1 class="text-2xl font-bold mb-6">Order Items</h1>
    <div class="flex justify-between items-center mb-6">
        <p class="text-slate-500">{{ $orderItems->count() }} order items</p>
        <a href="{{ route('admin.order-items.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700">+ New Item</a>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-left text-slate-500">
                <tr>
                    <th class="px-4 py-3">Order</th>
                    <th class="px-4 py-3">Product</th>
                    <th class="px-4 py-3">Qty</th>
                    <th class="px-4 py-3">Price</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($orderItems as $item)
                    <tr>
                        <td class="px-4 py-3 font-medium">#{{ $item->order_id }}</td>
                        <td class="px-4 py-3 text-slate-500">{{ $item->product->name ?? '—' }}</td>
                        <td class="px-4 py-3">{{ $item->quantity }}</td>
                        <td class="px-4 py-3">${{ number_format($item->price, 2) }}</td>
                        <td class="px-4 py-3 text-right space-x-3">
                            <a href="{{ route('admin.order-items.edit', $item) }}" class="text-indigo-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.order-items.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Delete this item?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-6 text-center text-slate-400">No order items yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
