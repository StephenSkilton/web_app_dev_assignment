@csrf
@isset($cartItem) @method('PUT') @endisset

<div class="space-y-5 max-w-lg">
    <div>
        <label class="block text-sm font-medium mb-1">Cart</label>
        <select name="cart_id" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
            <option value="">Select a cart</option>
            @foreach ($carts as $cart)
                <option value="{{ $cart->id }}" @selected(old('cart_id', $cartItem->cart_id ?? '') == $cart->id)>Cart #{{ $cart->id }} ({{ $cart->user->name ?? 'no user' }})</option>
            @endforeach
        </select>
        @error('cart_id') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Product</label>
        <select name="product_id" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
            <option value="">Select a product</option>
            @foreach ($products as $product)
                <option value="{{ $product->id }}" @selected(old('product_id', $cartItem->product_id ?? '') == $product->id)>{{ $product->name }}</option>
            @endforeach
        </select>
        @error('product_id') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Quantity</label>
        <input type="number" name="quantity" value="{{ old('quantity', $cartItem->quantity ?? 1) }}" min="1" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
        @error('quantity') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
    </div>

    <button type="submit" class="bg-indigo-600 text-white px-5 py-2.5 rounded-lg font-medium hover:bg-indigo-700">
        {{ isset($cartItem) ? 'Update Item' : 'Create Item' }}
    </button>
</div>
