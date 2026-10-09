@if($cart->items->count() > 0)
    <div class="space-y-4">
        @foreach($cart->items as $item)
            <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg border border-slate-100">
                <div class="flex-1 min-w-0">
                    <p class="font-medium text-sm text-slate-800 truncate">{{ $item->product->name }}</p>
                    <p class="text-xs text-slate-400">${{ number_format($item->product->price, 2) }} each</p>
                </div>

                <div class="flex items-center space-x-2 mx-4">
                    <button type="button"
                            data-id="{{ $item->id }}"
                            data-qty="{{ $item->quantity - 1 }}"
                            data-action="update"
                            {{ $item->quantity <= 1 ? 'disabled' : '' }}
                            aria-label="Decrease quantity"
                            class="cart-ctrl w-8 h-8 flex items-center justify-center bg-white border border-slate-200 rounded hover:bg-slate-100 text-slate-600 font-bold transition disabled:opacity-50">
                        -
                    </button>

                    <span class="w-8 text-center text-sm font-semibold text-slate-700">{{ $item->quantity }}</span>

                    <button type="button"
                            data-id="{{ $item->id }}"
                            data-qty="{{ $item->quantity + 1 }}"
                            data-action="update"
                            aria-label="Increase quantity"
                            class="cart-ctrl w-8 h-8 flex items-center justify-center bg-white border border-slate-200 rounded hover:bg-slate-100 text-slate-600 font-bold transition">
                        +
                    </button>
                </div>

                <div class="text-right flex items-center space-x-4">
                    <span class="text-sm font-semibold text-slate-900">${{ number_format($item->product->price * $item->quantity, 2) }}</span>
                    <button type="button"
                            data-id="{{ $item->id }}"
                            data-action="delete"
                            aria-label="Remove {{ $item->product->name }} from cart"
                            class="cart-ctrl text-red-500 hover:text-red-700 p-1 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                    </button>
                </div>
            </div>
        @endforeach

        <div class="border-t border-slate-100 pt-3 flex justify-between items-center text-sm">
            <span class="font-medium text-slate-500">Total Balance:</span>
            <span class="font-bold text-slate-900 text-base">${{ number_format($total, 2) }}</span>
        </div>
    </div>
@else
    <div class="text-center py-6 text-slate-400 text-sm">
        Your cart is empty!
    </div>
@endif
