<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Shop')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col font-sans antialiased">

    <header class="bg-white border-b border-slate-200 sticky top-0 z-10">
        <div class="max-w-6xl mx-auto px-4 flex items-center justify-between h-16">
            <a href="{{ route('products.index') }}" class="text-xl font-bold text-indigo-600">Shopfront</a>
            <nav class="flex items-center gap-6 text-sm font-medium">
                <a href="{{ route('products.index') }}" class="hover:text-indigo-600">Shop</a>
                  <form action="{{ route('products.search') }}" method="GET" class="flex items-center gap-1.5">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search products..."
                        class="w-40 rounded-lg border-slate-300 text-sm px-2.5 py-1 focus:border-indigo-500 focus:ring-indigo-500"
                    >
                    <button type="submit" class="text-slate-400 hover:text-indigo-600">Search</button>
                </form>

                @auth
                    @php
                        $__cartCount = \App\Models\CartItem::whereHas('cart', fn ($q) => $q->where('user_id', auth()->id()))->sum('quantity');
                    @endphp
                             <button x-data x-on:click="$dispatch('open-slide-over', { name: 'shopping-cart' })" class="relative">
    Cart <span id="cart-count" class="inline-flex items-center justify-center min-w-[1.25rem] h-5 px-1 text-xs font-semibold bg-indigo-600 text-white rounded-full">{{ $__cartCount }}</span>
</button>

                    <a href="{{ route('orders.index') }}" class="hover:text-indigo-600">My Orders</a>
                    <a href="{{ route('dashboard') }}" class="hover:text-indigo-600">Dashboard</a>

                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.products.index') }}" class="text-slate-400 hover:text-indigo-600">Admin</a>
                    @endif

                    <a href="{{ route('profile.edit') }}" class="hover:text-indigo-600">{{ auth()->user()->name }}</a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-slate-400 hover:text-indigo-600">Log out</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="hover:text-indigo-600">Log in</a>
                    <a href="{{ route('register') }}" class="hover:text-indigo-600">Register</a>
                @endauth
            </nav>
        </div>

        @auth
            @if (auth()->user()->isAdmin() && request()->routeIs('admin.*'))
                <div class="border-t border-slate-100 bg-slate-50">
                    <div class="max-w-6xl mx-auto px-4 flex items-center gap-1 h-11 text-sm overflow-x-auto">
                        <a href="{{ route('admin.products.index') }}" class="px-3 py-1.5 rounded-lg whitespace-nowrap {{ request()->routeIs('admin.products.*') ? 'bg-indigo-600 text-white' : 'text-slate-500 hover:bg-slate-200' }}">Products</a>
                        <a href="{{ route('admin.manufacturers.index') }}" class="px-3 py-1.5 rounded-lg whitespace-nowrap {{ request()->routeIs('admin.manufacturers.*') ? 'bg-indigo-600 text-white' : 'text-slate-500 hover:bg-slate-200' }}">Manufacturers</a>
                        <a href="{{ route('admin.orders.index') }}" class="px-3 py-1.5 rounded-lg whitespace-nowrap {{ request()->routeIs('admin.orders.*') ? 'bg-indigo-600 text-white' : 'text-slate-500 hover:bg-slate-200' }}">Orders</a>
                        <a href="{{ route('admin.order-items.index') }}" class="px-3 py-1.5 rounded-lg whitespace-nowrap {{ request()->routeIs('admin.order-items.*') ? 'bg-indigo-600 text-white' : 'text-slate-500 hover:bg-slate-200' }}">Order Items</a>
                        <a href="{{ route('admin.carts.index') }}" class="px-3 py-1.5 rounded-lg whitespace-nowrap {{ request()->routeIs('admin.carts.*') ? 'bg-indigo-600 text-white' : 'text-slate-500 hover:bg-slate-200' }}">Carts</a>
                        <a href="{{ route('admin.cart-items.index') }}" class="px-3 py-1.5 rounded-lg whitespace-nowrap {{ request()->routeIs('admin.cart-items.*') ? 'bg-indigo-600 text-white' : 'text-slate-500 hover:bg-slate-200' }}">Cart Items</a>
                        <a href="{{ route('admin.users.index') }}" class="px-3 py-1.5 rounded-lg whitespace-nowrap {{ request()->routeIs('admin.users.*') ? 'bg-indigo-600 text-white' : 'text-slate-500 hover:bg-slate-200' }}">Users</a>
                    </div>
                </div>
            @endif
        @endauth


    </header>

    @if (session('success'))
        <div class="max-w-6xl mx-auto px-4 mt-4">
            <div class="bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        </div>
    @endif

    <main class="flex-1 max-w-6xl mx-auto w-full px-4 py-8">
        @yield('content')
    </main>

    <footer class="bg-white border-t border-slate-200 py-6 text-center text-sm text-slate-400">
        &copy; {{ date('Y') }} Shopfront. All rights reserved.
    </footer>

    @auth
<x-slide-over name="shopping-cart" title="Your Shopping Cart">
    <!-- Body Content -->
    <div id="cart-modal-body" class="overflow-y-auto flex-1 min-h-[150px]">
        <div class="flex justify-center items-center h-full py-8">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-600"></div>
        </div>
    </div>

    <!-- Footer Content -->
    <div class="mt-6 pt-4 border-t border-slate-100 flex justify-end space-x-3">
        <button x-data type="button" x-on:click="$dispatch('close-slide-over')" class="px-4 py-2 border border-slate-300 rounded-lg text-xs font-medium text-slate-700 hover:bg-slate-100 transition">
            Continue Shopping
        </button>

        <form action="{{ route('cart.checkout') }}" method="POST">
            @csrf
            <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-medium rounded-lg transition shadow">
                Checkout Now
            </button>
        </form>
    </div>
</x-slide-over>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const modalBody = document.getElementById('cart-modal-body');
    const cartCountBadge = document.getElementById('cart-count');
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    const showLoader = () => {
        modalBody.innerHTML = `<div class="flex justify-center items-center py-12"><div class="animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-600"></div></div>`;
    };

    const showError = (message) => {
        modalBody.innerHTML = `<p class="text-red-500 text-center py-4">${message}</p>`;
    };

    const updateModalUI = (data) => {
        modalBody.innerHTML = data.html;
        if (cartCountBadge) cartCountBadge.textContent = data.count;
    };

    const handleResponse = (res) => {
        if (!res.ok) {
            if (res.status === 419) throw new Error('Your session expired. Please refresh the page.');
            if (res.status === 403) throw new Error("You don't have permission to do that.");
            throw new Error('Something went wrong. Please try again.');
        }
        return res.json();
    };

    const loadCartItems = () => {
        showLoader(); // Keep the loader ONLY for the initial full-panel opening
        fetch("{{ route('cart.modal-items') }}", {
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
        })
            .then(handleResponse)
            .then(updateModalUI)
            .catch((err) => showError(err.message || 'Failed to load your cart.'));
    };

    // Listen globally for Alpine's event dispatch
    window.addEventListener('open-slide-over', (e) => {
        if (e.detail && e.detail.name === 'shopping-cart') {
            loadCartItems();
        }
    });

    document.getElementById('open-cart-btn')?.addEventListener('click', () => {
        window.dispatchEvent(new CustomEvent('open-slide-over', { detail: { name: 'shopping-cart' } }));
    });

    @if (session('open_cart'))
        setTimeout(() => {
            window.dispatchEvent(new CustomEvent('open-slide-over', { detail: { name: 'shopping-cart' } }));
        }, 100);
    @endif

    // Event delegation for controls inside the body (+, -, delete)
    modalBody.addEventListener('click', (e) => {
        const targetBtn = e.target.closest('.cart-ctrl');
        if (!targetBtn) return;

        const id = targetBtn.dataset.id;
        const action = targetBtn.dataset.action;

        let endpoint = `/cart/items/${id}`;
        let options = {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
            },
        };

        if (action === 'update') {
            const qty = targetBtn.dataset.qty;
            options = {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify({ quantity: qty }),
            };
        }

        // --- FIXED HERE ---
        // Removed showLoader() so the existing UI stays active during updates.
        // Optional optimization: You can temporarily disable the clicked button here to prevent double clicks.
        targetBtn.disabled = true; 

        fetch(endpoint, options)
            .then(handleResponse)
            .then(updateModalUI)
            .catch((err) => {
                // If it fails, restore button stability or show error
                targetBtn.disabled = false;
                showError(err.message || 'Error processing request.');
            });
    });
});
</script>


@endauth
</body>
</html>
