<?php

use App\Http\Controllers\Admin\CartController as AdminCartController;
use App\Http\Controllers\Admin\CartItemController as AdminCartItemController;
use App\Http\Controllers\Admin\ManufacturerController as AdminManufacturerController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\OrderItemController as AdminOrderItemController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Storefront (public) routes
|--------------------------------------------------------------------------
*/
Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::get('/products', [ProductController::class, 'search'])->name('products.search');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
    Route::get('/cart/modal-items', [CartController::class, 'getModalItems'])->name('cart.modal-items');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/items/{cartItem}', [CartController::class, 'updateItem'])->name('cart.items.update');
    Route::delete('/cart/items/{cartItem}', [CartController::class, 'removeItem'])->name('cart.items.destroy');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
});

Route::middleware('auth')->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});

/*
|--------------------------------------------------------------------------
| Admin routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('products', AdminProductController::class)->except(['show']);
    Route::resource('manufacturers', AdminManufacturerController::class)->except(['show']);
    Route::resource('orders', AdminOrderController::class)->except(['show']);
    Route::resource('order-items', AdminOrderItemController::class)->except(['show']);
    Route::resource('carts', AdminCartController::class)->except(['show']);
    Route::resource('cart-items', AdminCartItemController::class)->except(['show']);
    Route::resource('users', AdminUserController::class)->except(['show']);
});

/*
|--------------------------------------------------------------------------
| Breeze auth-related routes
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__.'/auth.php';
