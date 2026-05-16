<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'My Ecommerce Store')</title>

    <!-- Tailwind CDN (your working setup) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        html {
            scroll-behavior: smooth;
        }

        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 20px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        body.sidebar-open {
            overflow: hidden;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen overflow-x-hidden flex flex-col">

@php
    $cartCount = count(session('cart', []));

    $wishlistCount = auth()->check()
        ? \App\Models\Wishlist::where('user_id', auth()->id())->count()
        : 0;

    $flashSales = $flashSales ?? collect();
@endphp

<!-- =========================
     MOBILE OVERLAY (ADMIN STYLE)
========================= -->
<div id="sidebar-overlay"
     class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden"></div>

<div class="flex h-screen overflow-hidden">

    <!-- =========================
         SIDEBAR (ADMIN STYLE)
    ========================== -->
    <aside id="sidebar"
           class="fixed lg:static inset-y-0 left-0 z-50
                  w-72 bg-gray-900 text-white
                  transform -translate-x-full lg:translate-x-0
                  transition-transform duration-300 ease-in-out
                  flex flex-col shadow-xl">

        <!-- BRAND -->
        <div class="p-6 border-b border-gray-800 flex items-center justify-between">

            <div>
                <h1 class="text-2xl font-extrabold tracking-tight">
                    Shop
                </h1>

                <p class="text-xs text-gray-400 mt-1">
                    Ecommerce Store
                </p>
            </div>

            <button id="close-sidebar"
                    class="lg:hidden text-2xl text-gray-400 hover:text-white transition">
                ✕
            </button>

        </div>

        <!-- NAVIGATION -->
        <nav class="flex-1 overflow-y-auto p-4 space-y-2 text-sm">

            <a href="{{ route('home') }}"
               class="block px-4 py-3 rounded-lg hover:bg-gray-800">
                Home
            </a>

            <a href="{{ route('shop') }}"
               class="block px-4 py-3 rounded-lg hover:bg-gray-800">
                Shop
            </a>

            @auth
                <a href="{{ route('orders.my') }}"
                   class="block px-4 py-3 rounded-lg hover:bg-gray-800">
                    My Orders
                </a>

                <a href="{{ route('wishlist.index') }}"
                   class="block px-4 py-3 rounded-lg hover:bg-gray-800">
                    Wishlist
                </a>

                <a href="{{ route('profile.edit') }}"
                   class="block px-4 py-3 rounded-lg hover:bg-gray-800">
                    Profile
                </a>

                <a href="{{ route('dashboard') }}"
                   class="block px-4 py-3 rounded-lg hover:bg-gray-800">
                    Dashboard
                </a>
            @endauth

        </nav>

        <!-- USER FOOTER -->
        <div class="p-4 border-t border-gray-800">

            <div class="flex items-center justify-between gap-3">

                <div class="min-w-0">
                    <p class="text-sm font-semibold truncate">
                        {{ auth()->user()->name ?? 'Guest' }}
                    </p>

                    <p class="text-xs text-gray-400 truncate">
                        {{ auth()->user()->email ?? '' }}
                    </p>
                </div>

                @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-red-400 hover:text-red-300 text-sm">
                        Logout
                    </button>
                </form>
                @endauth

            </div>

        </div>

    </aside>

    <!-- =========================
         MAIN CONTENT AREA
    ========================== -->
    <div class="flex-1 flex flex-col overflow-hidden min-w-0">

        <!-- =========================
             TOP BAR (MIXED STYLE)
        ========================== -->
        <div class="bg-gray-900 text-white text-xs sm:text-sm">

            <div class="max-w-7xl mx-auto px-4 py-2 flex flex-col sm:flex-row justify-between gap-2">

                <div class="flex gap-4 flex-wrap">
                    <span>🚚 Fast Delivery</span>
                    <span>🔒 Secure Payments</span>
                </div>

                <div class="flex gap-4 flex-wrap">
                    <span>📞 +254 700 000 000</span>
                    <span class="hidden sm:block">✉ support@shop.com</span>
                </div>

            </div>
        </div>

        <!-- NAVBAR -->
        <nav class="bg-white shadow sticky top-0 z-30">

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="flex justify-between items-center h-16">

                    <!-- LEFT -->
                    <div class="flex items-center gap-4">

                        <button id="open-sidebar"
                                class="lg:hidden text-2xl text-gray-700">
                            ☰
                        </button>

                        <a href="{{ route('home') }}"
                           class="text-2xl font-extrabold text-blue-600">
                            Shop
                        </a>

                    </div>

                    <!-- RIGHT -->
                    <div class="flex items-center gap-4 text-2xl">

                        @auth
                        <a href="{{ route('wishlist.index') }}" class="relative">
                            ❤
                            @if($wishlistCount > 0)
                                <span class="absolute -top-2 -right-3 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">
                                    {{ $wishlistCount }}
                                </span>
                            @endif
                        </a>
                        @endauth

                        <a href="{{ route('cart.index') }}" class="relative">
                            🛒
                            @if($cartCount > 0)
                                <span class="absolute -top-2 -right-3 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>

                    </div>

                </div>

            </div>
        </nav>

        <!-- FLASH BANNER -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white text-center py-3 text-sm font-medium">
            🔥 Big Discounts Available Today — Shop Now & Save More
        </div>

        <!-- PAGE CONTENT -->
        <main class="flex-1 overflow-y-auto">

            <div class="max-w-7xl mx-auto px-4 py-6">

                @yield('content')

            </div>

            <!-- NEWSLETTER -->
            <section class="bg-white border-t mt-10">

                <div class="max-w-7xl mx-auto px-4 py-10 grid lg:grid-cols-2 gap-6 items-center">

                    <div>
                        <h2 class="text-2xl font-bold">Subscribe to our newsletter</h2>
                        <p class="text-gray-500">Get updates on deals and new arrivals.</p>
                    </div>

                    <form class="flex gap-3">
                        <input type="email"
                               class="flex-1 border rounded-lg px-4 py-3"
                               placeholder="Enter email">

                        <button class="bg-blue-600 text-white px-6 py-3 rounded-lg">
                            Subscribe
                        </button>
                    </form>

                </div>

            </section>

<!-- =========================
     FOOTER
========================= -->
<footer class="bg-gray-900 text-gray-300 mt-10">

    <div class="max-w-7xl mx-auto px-4 py-12">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">

            <!-- ABOUT -->
            <div>

                <h3 class="text-white text-lg font-bold mb-4">
                    Shop
                </h3>

                <p class="text-sm leading-6 text-gray-400">
                    Modern ecommerce experience with secure checkout,
                    fast delivery, and amazing products.
                </p>

            </div>

            <!-- QUICK LINKS -->
            <div>

                <h3 class="text-white text-lg font-bold mb-4">
                    Quick Links
                </h3>

                <ul class="space-y-2 text-sm">

                    <li>
                        <a href="{{ route('home') }}"
                           class="hover:text-white">
                            Home
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('shop') }}"
                           class="hover:text-white">
                            Shop
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('cart.index') }}"
                           class="hover:text-white">
                            Cart
                        </a>
                    </li>

                </ul>

            </div>

            <!-- CUSTOMER -->
            <div>

                <h3 class="text-white text-lg font-bold mb-4">
                    Customer
                </h3>

                <ul class="space-y-2 text-sm">

                    @auth

                    <li>
                        <a href="{{ route('wishlist.index') }}"
                           class="hover:text-white">
                            Wishlist
                        </a>
                    </li>

                    @endauth

                    <li>Help Center</li>
                    <li>Returns</li>
                    <li>Shipping</li>
                    <li>Privacy Policy</li>

                </ul>

            </div>

            <!-- CONTACT -->
            <div>

                <h3 class="text-white text-lg font-bold mb-4">
                    Contact
                </h3>

                <ul class="space-y-2 text-sm text-gray-400">

                    <li>📞 +254 700 000 000</li>
                    <li>✉ support@shop.com</li>
                    <li>📍 Nairobi, Kenya</li>

                </ul>

            </div>

        </div>

        <!-- BOTTOM -->
        <div class="border-t border-gray-800 mt-10 pt-6 text-center text-sm text-gray-500">

            © {{ date('Y') }} My Ecommerce Store.
            All rights reserved.

        </div>

    </div>

</footer>

        </main>

    </div>

</div>

<!-- =========================
     SIDEBAR SCRIPT (ADMIN STYLE)
========================= -->
<script>

    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');

    const openBtn = document.getElementById('open-sidebar');
    const closeBtn = document.getElementById('close-sidebar');

    function openSidebar() {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
        document.body.classList.add('sidebar-open');
    }

    function closeSidebar() {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
        document.body.classList.remove('sidebar-open');
    }

    openBtn?.addEventListener('click', openSidebar);
    closeBtn?.addEventListener('click', closeSidebar);
    overlay?.addEventListener('click', closeSidebar);

</script>

</body>
</html>
