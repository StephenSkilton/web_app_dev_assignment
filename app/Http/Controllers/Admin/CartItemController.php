<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    public function index()
    {
        $cartItems = CartItem::with(['cart', 'product'])->get();

        return view('admin.cart-items.index', compact('cartItems'));
    }

    public function create()
    {
        $carts = Cart::with('user')->get();
        $products = Product::all();

        return view('admin.cart-items.create', compact('carts', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cart_id' => 'required|exists:carts,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:1000',
        ]);

        $cartItem = CartItem::where('cart_id', $validated['cart_id'])
            ->where('product_id', $validated['product_id'])
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $validated['quantity']);
        } else {
            CartItem::create($validated);
        }

        return redirect()->route('admin.cart-items.index')->with('success', 'Cart item added successfully.');
    }

    public function edit(CartItem $cartItem)
    {
        $carts = Cart::with('user')->get();
        $products = Product::all();

        return view('admin.cart-items.edit', compact('cartItem', 'carts', 'products'));
    }

    public function update(Request $request, CartItem $cartItem)
    {
        $validated = $request->validate([
            'cart_id' => 'required|exists:carts,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:1000',
        ]);

        $cartItem->update($validated);

        return redirect()->route('admin.cart-items.index')->with('success', 'Cart item updated successfully.');
    }

    public function destroy(CartItem $cartItem)
    {
        $cartItem->delete();

        return redirect()->route('admin.cart-items.index')->with('success', 'Cart item deleted successfully.');
    }
}
