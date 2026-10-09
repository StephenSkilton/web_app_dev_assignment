@extends('layouts.app')
@section('title', 'Products')
@section('content')
    <h1 class="text-2xl font-bold mb-6">Products</h1>
    <div class="flex justify-between items-center mb-6">
        <p class="text-slate-500">{{ $products->count() }} products</p>
        <a href="{{ route('admin.products.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700">+ New Product</a>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-left text-slate-500">
                <tr>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">SKU</th>
                    <th class="px-4 py-3">Manufacturer</th>
                    <th class="px-4 py-3">Price</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($products as $product)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ $product->name }}</td>
                        <td class="px-4 py-3 text-slate-500">{{ $product->sku }}</td>
                        <td class="px-4 py-3 text-slate-500">{{ $product->manufacturer->name ?? '—' }}</td>
                        <td class="px-4 py-3 text-slate-500">{{ $product->description ?? '—' }}</td>
                        <td class="px-4 py-3">${{ number_format($product->price, 2) }}</td>
                        <td class="px-4 py-3 text-right space-x-3">
                            <a href="{{ route('admin.products.edit', $product) }}" class="text-indigo-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Delete this product?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-6 text-center text-slate-400">No products yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
