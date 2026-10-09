<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->get();

        return view('admin.orders.index', compact('orders'));
    }

    public function create()
    {
        $users = User::all();

        return view('admin.orders.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'status' => 'required|in:pending,processing,completed,cancelled',
            'total' => 'required|numeric|min:0|max:999999.99',
        ]);

        Order::create($validated);

        return redirect()->route('admin.orders.index')->with('success', 'Order created successfully.');
    }

    public function edit(Order $order)
    {
        $users = User::all();

        return view('admin.orders.edit', compact('order', 'users'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'status' => 'required|in:pending,processing,completed,cancelled',
            'total' => 'required|numeric|min:0|max:999999.99',
        ]);

        $order->update($validated);

        return redirect()->route('admin.orders.index')->with('success', 'Order updated successfully.');
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully.');
    }
}
