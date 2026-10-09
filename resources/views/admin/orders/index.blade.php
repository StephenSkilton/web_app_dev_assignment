@extends('layouts.app')
@section('title', 'Orders')
@section('content')
    <h1 class="text-2xl font-bold mb-6">Orders</h1>
    <div class="flex justify-between items-center mb-6">
        <p class="text-slate-500">{{ $orders->count() }} orders</p>
        <a href="{{ route('admin.orders.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700">+ New Order</a>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-left text-slate-500">
                <tr>
                    <th class="px-4 py-3">#</th>
                    <th class="px-4 py-3">User</th>
                    <th class="px-4 py-3">Date</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Total</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($orders as $order)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ $order->id }}</td>
                        <td class="px-4 py-3 text-slate-500">{{ $order->user->name ?? '—' }}</td>
                        <td class="px-4 py-3 text-slate-500">{{ \Carbon\Carbon::parse($order->date)->format('M j, Y') }}</td>
                        <td class="px-4 py-3"><span class="capitalize">{{ $order->status }}</span></td>
                        <td class="px-4 py-3">${{ number_format($order->total, 2) }}</td>
                        <td class="px-4 py-3 text-right space-x-3">
                            <a href="{{ route('orders.show', $order) }}" class="text-slate-500 hover:underline">View</a>
                            <a href="{{ route('admin.orders.edit', $order) }}" class="text-indigo-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="inline" onsubmit="return confirm('Delete this order?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-6 text-center text-slate-400">No orders yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
