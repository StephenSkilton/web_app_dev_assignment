<a href="{{ route('products.show', $product) }}" class="group bg-white rounded-xl border border-slate-200 p-4 hover:shadow-md transition">
    <div class="aspect-square bg-slate-100 rounded-lg mb-3 flex items-center justify-center text-slate-300 text-sm overflow-hidden">
        @if ($product->image_url)
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
        @else
            No image
        @endif
    </div>
    <p class="text-xs text-slate-400 mb-1">{{ $product->manufacturer->name ?? 'Unbranded' }}</p>
    <h2 class="font-medium text-slate-800 group-hover:text-indigo-600 mb-1">{{ $product->name }}</h2>
    <p class="font-semibold">${{ number_format($product->price, 2) }}</p>
</a>
