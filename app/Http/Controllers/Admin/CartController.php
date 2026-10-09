<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::with(['user', 'items', 'products'])->get();

        return view('admin.carts.index', compact('carts'));
    }

    public function create()
    {
        $users = User::all();

        return view('admin.carts.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        Cart::create($validated);

        return redirect()->route('admin.carts.index')->with('success', 'Cart created.');
    }

    public function edit(Cart $cart)
    {
        $users = User::all();

        return view('admin.carts.edit', compact('cart', 'users'));
    }

    public function update(Request $request, Cart $cart)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $cart->update($validated);

        return redirect()->route('admin.carts.index')->with('success', 'Cart updated.');
    }

    public function destroy(Cart $cart)
    {
        $cart->delete();

        return redirect()->route('admin.carts.index')->with('success', 'Cart deleted.');
    }
}
