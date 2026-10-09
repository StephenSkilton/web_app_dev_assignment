@csrf
@isset($orderItem) @method('PUT') @endisset

<div class="space-y-5 max-w-lg">
    <div>
        <label class="block text-sm font-medium mb-1">Order</label>
        <select name="order_id" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
            <option value="">Select an order</option>
            @foreach ($orders as $order)
                <option value="{{ $order->id }}" @selected(old('order_id', $orderItem->order_id ?? '') == $order->id)>Order #{{ $order->id }}</option>
            @endforeach
        </select>
        @error('order_id') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Product</label>
        <select name="product_id" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
            <option value="">Select a product</option>
            @foreach ($products as $product)
                <option value="{{ $product->id }}" @selected(old('product_id', $orderItem->product_id ?? '') == $product->id)>{{ $product->name }}</option>
            @endforeach
        </select>
        @error('product_id') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Quantity</label>
        <input type="number" name="quantity" value="{{ old('quantity', $orderItem->quantity ?? 1) }}" min="1" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
        @error('quantity') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Price</label>
        <input type="number" step="0.01" name="price" value="{{ old('price', $orderItem->price ?? '') }}" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
        @error('price') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
    </div>

    <button type="submit" class="bg-indigo-600 text-white px-5 py-2.5 rounded-lg font-medium hover:bg-indigo-700">
        {{ isset($orderItem) ? 'Update Item' : 'Create Item' }}
    </button>
</div>
