<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function index()
    {
        $orderItems = OrderItem::with(['order', 'product'])->get();

        return view('admin.order-items.index', compact('orderItems'));
    }

    public function create()
    {
        $orders = Order::all();
        $products = Product::all();

        return view('admin.order-items.create', compact('orders', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:1000',
            'price' => 'required|numeric|min:0|max:999999.99',
        ]);

        OrderItem::create($validated);

        return redirect()->route('admin.order-items.index')->with('success', 'Order item created successfully.');
    }

    public function edit(OrderItem $orderItem)
    {
        $orders = Order::all();
        $products = Product::all();

        return view('admin.order-items.edit', compact('orderItem', 'orders', 'products'));
    }

    public function update(Request $request, OrderItem $orderItem)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:1000',
            'price' => 'required|numeric|min:0|max:999999.99',
        ]);

        $orderItem->update($validated);

        return redirect()->route('admin.order-items.index')->with('success', 'Order item updated successfully.');
    }

    public function destroy(OrderItem $orderItem)
    {
        $orderItem->delete();

        return redirect()->route('admin.order-items.index')->with('success', 'Order item deleted successfully.');
    }
}
