<?php

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Manufacturer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;

test('order belongs to a user', function () {
    $user = User::factory()->create();
    $order = Order::factory()->create(['user_id' => $user->id]);

    expect($order->user)->toBeInstanceOf(User::class);
    expect($order->user->id)->toBe($user->id);
});

test('order has many order items', function () {
    $order = Order::factory()->create();
    OrderItem::factory()->count(3)->create(['order_id' => $order->id]);

    expect($order->items)->toHaveCount(3);
    expect($order->items->first())->toBeInstanceOf(OrderItem::class);
});

test('order item belongs to an order and a product', function () {
    $order = Order::factory()->create();
    $product = Product::factory()->create();
    $item = OrderItem::factory()->create(['order_id' => $order->id, 'product_id' => $product->id]);

    expect($item->order->id)->toBe($order->id);
    expect($item->product->id)->toBe($product->id);
});

test('order item subtotal is quantity times price', function () {
    $item = OrderItem::factory()->create(['quantity' => 3, 'price' => 9.50]);

    expect((float) $item->subtotal)->toBe(28.5);
});

test('cart belongs to a user and has many cart items', function () {
    $user = User::factory()->create();
    $cart = Cart::factory()->create(['user_id' => $user->id]);
    CartItem::factory()->count(2)->create(['cart_id' => $cart->id]);

    expect($cart->user->id)->toBe($user->id);
    expect($cart->items)->toHaveCount(2);
});

test('cart item belongs to a cart and a product', function () {
    $cart = Cart::factory()->create();
    $product = Product::factory()->create();
    $item = CartItem::factory()->create(['cart_id' => $cart->id, 'product_id' => $product->id]);

    expect($item->cart->id)->toBe($cart->id);
    expect($item->product->id)->toBe($product->id);
});

test('product belongs to a manufacturer', function () {
    $manufacturer = Manufacturer::factory()->create();
    $product = Product::factory()->create(['manufacturer_id' => $manufacturer->id]);

    expect($product->manufacturer->id)->toBe($manufacturer->id);
});

test('manufacturer has many products', function () {
    $manufacturer = Manufacturer::factory()->create();
    Product::factory()->count(4)->create(['manufacturer_id' => $manufacturer->id]);

    expect($manufacturer->products)->toHaveCount(4);
});

test('a new user defaults to the customer role', function () {
    $user = User::factory()->create();

    expect($user->role)->toBe('customer');
});
