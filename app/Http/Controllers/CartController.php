<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Centralised fetch of the current user's active cart.
    private function getUserCart()
    {
        return Cart::with('items.product')->firstOrCreate(['user_id' => auth()->id()]);
    }

    // Endpoint the modal's JS fetches to (re)load its contents.
    public function getModalItems(Request $request)
    {
        $cart = $this->getUserCart();
        $total = $cart->items->sum(fn ($item) => $item->quantity * $item->product->price);

        return response()->json([
            'html' => view('cart.partials.modal-items', compact('cart', 'total'))->render(),
            'count' => $cart->items->sum('quantity'),
        ]);
    }

    public function show()
    {
        $cart = $this->getUserCart();

        return view('cart.show', compact('cart'));
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:1000',
        ]);

        $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);

        $item = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $validated['product_id'])
            ->first();

        if ($item) {
            $item->increment('quantity', $validated['quantity']);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity'],
            ]);
        }

        if ($request->ajax()) {
            return $this->getModalItems($request);
        }

        return redirect()->back()->with(['success' => 'Added to cart.', 'open_cart' => true]);
    }

    public function updateItem(Request $request, CartItem $cartItem)
    {
        abort_unless($cartItem->cart->user_id === auth()->id(), 403);

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:1000',
        ]);

        $cartItem->update($validated);

        if ($request->ajax()) {
            return $this->getModalItems($request);
        }

        return redirect()->back()->with(['success' => 'Cart updated.', 'open_cart' => true]);
    }

    public function removeItem(Request $request, CartItem $cartItem)
    {
        abort_unless($cartItem->cart->user_id === auth()->id(), 403);

        $cartItem->delete();

        if ($request->ajax()) {
            return $this->getModalItems($request);
        }

        return redirect()->back()->with(['success' => 'Item removed.', 'open_cart' => true]);
    }

    public function checkout()
    {
        $cart = $this->getUserCart();

        if ($cart->items->isEmpty()) {
            return redirect()->back()->with(['success' => 'Your cart is empty.', 'open_cart' => true]);
        }

        $order = Order::create([
            'user_id' => auth()->id(),
            'date' => now()->toDateString(),
            'status' => 'pending',
            'total' => $cart->items->sum(fn ($item) => $item->quantity * $item->product->price),
        ]);

        foreach ($cart->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
        }

        $cart->items()->delete();

        return redirect()->route('orders.show', $order)->with('success', 'Order placed successfully.');
    }
}
