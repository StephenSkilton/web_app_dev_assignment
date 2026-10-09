@extends('layouts.app')
@section('title', 'Carts')
@section('content')
    <h1 class="text-2xl font-bold mb-6">Carts</h1>
    <div class="flex justify-between items-center mb-6">
        <p class="text-slate-500">{{ $carts->count() }} carts</p>
        <a href="{{ route('admin.carts.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700">+ New Cart</a>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-left text-slate-500">
                <tr>
                    <th class="px-4 py-3">#</th>
                    <th class="px-4 py-3">User</th>
                    <th class="px-4 py-3">Items</th>
                    <th class="px-4 py-3">Products</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($carts as $cart)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ $cart->id }}</td>
                        <td class="px-4 py-3 text-slate-500">{{ $cart->user->name ?? '—' }}</td>
                        <td class="px-4 py-3 text-slate-500">{{ $cart->items->count() }}</td>
                        <td class="px-4 py-3 text-slate-500">{{ $cart->products->pluck('name')->join(', ') ?: '—' }}</td>
                        <td class="px-4 py-3 text-right space-x-3">
                            <a href="{{ route('admin.carts.edit', $cart) }}" class="text-indigo-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.carts.destroy', $cart) }}" method="POST" class="inline" onsubmit="return confirm('Delete this cart?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-6 text-center text-slate-400">No carts yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
