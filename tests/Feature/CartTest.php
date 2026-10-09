<?php

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

test('guests cannot view the cart', function () {
    $response = $this->get(route('cart.show'));

    $response->assertRedirect(route('login'));
});

test('viewing the cart creates one if it does not exist yet', function () {
    $user = User::factory()->create();

    expect(Cart::where('user_id', $user->id)->exists())->toBeFalse();

    $this->actingAs($user)->get(route('cart.show'))->assertOk();

    expect(Cart::where('user_id', $user->id)->exists())->toBeTrue();
});

test('adding a product creates a new cart item', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create();

    $this->actingAs($user)->post(route('cart.add'), [
        'product_id' => $product->id,
        'quantity' => 2,
    ])->assertRedirect();

    $this->assertDatabaseHas('cart_items', [
        'product_id' => $product->id,
        'quantity' => 2,
    ]);
});

test('adding the same product twice increments quantity instead of duplicating the row', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create();

    $this->actingAs($user)->post(route('cart.add'), ['product_id' => $product->id, 'quantity' => 1]);
    $this->actingAs($user)->post(route('cart.add'), ['product_id' => $product->id, 'quantity' => 2]);

    $cart = Cart::where('user_id', $user->id)->first();

    expect($cart->items)->toHaveCount(1);
    expect($cart->items->first()->quantity)->toBe(3);
});

test('adding a product via ajax returns the modal json', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create();

    $response = $this->actingAs($user)
        ->withHeaders(['X-Requested-With' => 'XMLHttpRequest'])
        ->post(route('cart.add'), ['product_id' => $product->id, 'quantity' => 1]);

    $response->assertOk();
    $response->assertJsonStructure(['html', 'count']);
    $response->assertJson(['count' => 1]);
});

test('a user can update the quantity of their own cart item', function () {
    $user = User::factory()->create();
    $cart = Cart::factory()->create(['user_id' => $user->id]);
    $item = CartItem::factory()->create(['cart_id' => $cart->id, 'quantity' => 1]);

    $this->actingAs($user)
        ->put(route('cart.items.update', $item), ['quantity' => 5])
        ->assertRedirect();

    expect($item->fresh()->quantity)->toBe(5);
});

test('a user cannot update a cart item belonging to someone else', function () {
    $owner = User::factory()->create();
    $intruder = User::factory()->create();
    $cart = Cart::factory()->create(['user_id' => $owner->id]);
    $item = CartItem::factory()->create(['cart_id' => $cart->id, 'quantity' => 1]);

    $this->actingAs($intruder)
        ->put(route('cart.items.update', $item), ['quantity' => 99])
        ->assertForbidden();

    expect($item->fresh()->quantity)->toBe(1);
});

test('a user can remove their own cart item', function () {
    $user = User::factory()->create();
    $cart = Cart::factory()->create(['user_id' => $user->id]);
    $item = CartItem::factory()->create(['cart_id' => $cart->id]);

    $this->actingAs($user)
        ->delete(route('cart.items.destroy', $item))
        ->assertRedirect();

    $this->assertDatabaseMissing('cart_items', ['id' => $item->id]);
});

test('a user cannot remove a cart item belonging to someone else', function () {
    $owner = User::factory()->create();
    $intruder = User::factory()->create();
    $cart = Cart::factory()->create(['user_id' => $owner->id]);
    $item = CartItem::factory()->create(['cart_id' => $cart->id]);

    $this->actingAs($intruder)
        ->delete(route('cart.items.destroy', $item))
        ->assertForbidden();

    $this->assertDatabaseHas('cart_items', ['id' => $item->id]);
});

test('checkout turns the cart into an order and empties the cart', function () {
    $user = User::factory()->create();
    $cart = Cart::factory()->create(['user_id' => $user->id]);
    $product = Product::factory()->create(['price' => 10]);
    CartItem::factory()->create(['cart_id' => $cart->id, 'product_id' => $product->id, 'quantity' => 3]);

    $response = $this->actingAs($user)->post(route('cart.checkout'));

    $order = Order::where('user_id', $user->id)->first();

    expect($order)->not->toBeNull();
    expect((float) $order->total)->toBe(30.0);
    expect($order->items)->toHaveCount(1);
    expect($order->items->first()->quantity)->toBe(3);
    expect($cart->fresh()->items)->toHaveCount(0);

    $response->assertRedirect(route('orders.show', $order));
});

test('checkout with an empty cart does not create an order', function () {
    $user = User::factory()->create();
    Cart::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user)->post(route('cart.checkout'))->assertRedirect();

    expect(Order::where('user_id', $user->id)->count())->toBe(0);
});
