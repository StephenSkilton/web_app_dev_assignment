<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderController extends Controller
{
    // Storefront: the current user's own order history.
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())->latest('date')->get();

        return view('orders.index', compact('orders'));
    }

    // Storefront: view a single order confirmation/detail.
    // Full admin CRUD lives in App\Http\Controllers\Admin\OrderController.
    public function show(Order $order)
    {
        abort_unless(
            auth()->id() === $order->user_id || auth()->user()->isAdmin(),
            403
        );

        $order->load(['user', 'items.product']);

        return view('orders.show', compact('order'));
    }
}
