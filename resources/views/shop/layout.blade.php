<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'My Ecommerce Store')</title>

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
    </style>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

@php

    $cartCount = count(session('cart', []));

    $wishlistCount = auth()->check()
        ? \App\Models\Wishlist::where('user_id', auth()->id())->count()
        : 0;

    /*
    |------------------------------------------
    | FLASH SALE GLOBAL FLAG (SAFE DEFAULT)
    |------------------------------------------
    */
    $flashSales = $flashSales ?? collect();

@endphp

<!-- =========================
     TOP BAR
========================= -->
<div class="bg-gray-900 text-white text-xs sm:text-sm">

    <div class="max-w-7xl mx-auto px-4 py-2 flex flex-col sm:flex-row justify-between gap-2">

        <div class="flex items-center gap-4 flex-wrap">
            <span>🚚 Fast Delivery</span>
            <span>🔒 Secure Payments</span>
        </div>

        <div class="flex items-center gap-4 flex-wrap">

            <span>📞 +254 700 000 000</span>

            <span class="hidden sm:block">
                ✉ support@shop.com
            </span>

        </div>

    </div>

</div>

<!-- =========================
     NAVBAR
========================= -->
<nav class="bg-white shadow sticky top-0 z-50">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex justify-between items-center h-16 gap-3">

            <!-- LEFT SIDE -->
            <div class="flex items-center gap-4 lg:gap-8">

                <!-- LOGO -->
                <a href="{{ route('home') }}"
                   class="text-2xl font-extrabold text-blue-600 tracking-tight whitespace-nowrap">
                    Shop
                </a>

                <!-- DESKTOP NAV -->
                <div class="hidden lg:flex items-center gap-6 text-gray-700 font-medium">

                    <a href="{{ route('home') }}"
                       class="hover:text-blue-600 transition">
                        Home
                    </a>

                    <a href="{{ route('shop') }}"
                       class="hover:text-blue-600 transition">
                        Shop
                    </a>

                    @auth

                        <a href="{{ route('orders.my') }}"
                           class="hover:text-blue-600 transition">
                            My Orders
                        </a>

                        <a href="{{ route('wishlist.index') }}"
                           class="hover:text-red-500 transition">
                            Wishlist
                        </a>

                        <a href="{{ route('profile.edit') }}"
                           class="hover:text-blue-600 transition">
                            Profile
                        </a>

                    @endauth

                </div>

            </div>

            <!-- SEARCH -->
            <div class="hidden md:flex flex-1 max-w-2xl mx-4 lg:mx-8">

                <form action="{{ route('shop') }}"
                      method="GET"
                      class="w-full">

                    <div class="flex items-center bg-gray-100 border border-gray-200 rounded-full overflow-hidden">

                        <div class="px-4 text-gray-400">
                            🔍
                        </div>

                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search products, categories..."
                            class="w-full bg-transparent py-3 px-2 focus:outline-none">

                        <button
                            type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 lg:px-6 py-3 transition whitespace-nowrap">

                            Search
                        </button>

                    </div>

                </form>

            </div>

            <!-- RIGHT SIDE -->
            <div class="flex items-center gap-4 sm:gap-5">

                <!-- WISHLIST -->
                @auth

                <a href="{{ route('wishlist.index') }}"
                   class="relative hidden sm:flex items-center justify-center text-gray-700 hover:text-red-500 transition text-2xl">

                    ❤

                    @if($wishlistCount > 0)

                        <span class="absolute -top-2 -right-3 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center font-bold">
                            {{ $wishlistCount }}
                        </span>

                    @endif

                </a>

                @endauth

                <!-- CART -->
                <a href="{{ route('cart.index') }}"
                   class="relative text-gray-700 hover:text-blue-600 transition text-2xl">

                    🛒

                    @if($cartCount > 0)

                        <span class="absolute -top-2 -right-3 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center font-bold">
                            {{ $cartCount }}
                        </span>

                    @endif

                </a>

                <!-- DESKTOP AUTH -->
                <div class="hidden lg:flex items-center gap-4">

                    @auth

                        <a href="{{ route('dashboard') }}"
                           class="text-gray-700 hover:text-blue-600 transition">
                            Dashboard
                        </a>

                        <form method="POST"
                              action="{{ route('logout') }}">
                            @csrf

                            <button class="text-red-500 hover:text-red-700 transition">
                                Logout
                            </button>
                        </form>

                    @else

                        <a href="{{ route('login') }}"
                           class="hover:text-blue-600 transition">
                            Login
                        </a>

                        <a href="{{ route('register') }}"
                           class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition whitespace-nowrap">
                            Register
                        </a>

                    @endauth

                </div>

                <!-- MOBILE MENU BUTTON -->
                <button id="mobile-menu-btn"
                        class="lg:hidden text-3xl text-gray-700">

                    ☰
                </button>

            </div>

        </div>

        <!-- MOBILE SEARCH -->
        <div class="md:hidden pb-4">

            <form action="{{ route('shop') }}"
                  method="GET">

                <div class="flex items-center bg-gray-100 border border-gray-200 rounded-full overflow-hidden">

                    <div class="px-4 text-gray-400">
                        🔍
                    </div>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search products..."
                        class="w-full bg-transparent py-3 px-2 focus:outline-none text-sm">

                    <button
                        type="submit"
                        class="bg-blue-600 text-white px-4 py-3 whitespace-nowrap">

                        Go
                    </button>

                </div>

            </form>

        </div>

    </div>

    <!-- =========================
         MOBILE MENU
    ========================= -->
    <div id="mobile-menu"
         class="hidden lg:hidden border-t bg-white shadow-md">

        <div class="px-4 py-5 space-y-5 text-gray-700">

            <a href="{{ route('home') }}"
               class="block hover:text-blue-600 font-medium">
                Home
            </a>

            <a href="{{ route('shop') }}"
               class="block hover:text-blue-600 font-medium">
                Shop
            </a>

            @auth

                <a href="{{ route('orders.my') }}"
                   class="block hover:text-blue-600 font-medium">
                    My Orders
                </a>

                <a href="{{ route('wishlist.index') }}"
                   class="block hover:text-red-500 font-medium">
                    Wishlist
                </a>

                <a href="{{ route('profile.edit') }}"
                   class="block hover:text-blue-600 font-medium">
                    Profile
                </a>

                <a href="{{ route('dashboard') }}"
                   class="block hover:text-blue-600 font-medium">
                    Dashboard
                </a>

                <form method="POST"
                      action="{{ route('logout') }}">
                    @csrf

                    <button class="text-red-500 font-medium">
                        Logout
                    </button>
                </form>

            @else

                <a href="{{ route('login') }}"
                   class="block hover:text-blue-600 font-medium">
                    Login
                </a>

                <a href="{{ route('register') }}"
                   class="block hover:text-blue-600 font-medium">
                    Register
                </a>

            @endauth

        </div>

    </div>

</nav>

<!-- =========================
     HERO FLASH BANNER
========================= -->
<div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white">

    <div class="max-w-7xl mx-auto px-4 py-3 text-center text-sm sm:text-base font-medium">

        🔥 Big Discounts Available Today — Shop Now & Save More

    </div>

</div>

<!-- =========================
     FLASH SALES PREVIEW BAR
========================= -->
@if($flashSales->count())

<div class="bg-white border-b">

    <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">

        <div class="flex items-center gap-2 text-sm font-semibold text-gray-700">
            ⚡ Flash Deals Available
        </div>

        <a href="{{ route('shop', ['sort' => 'flash']) }}"
           class="text-sm text-red-600 hover:underline font-medium whitespace-nowrap">

            View Flash Sales →

        </a>

    </div>

</div>

@endif

<!-- =========================
     PAGE CONTENT
========================= -->
<main class="flex-1">

    <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 sm:py-6">

        @yield('content')

    </div>

</main>

<!-- =========================
     NEWSLETTER
========================= -->
<section class="bg-white border-t">

    <div class="max-w-7xl mx-auto px-4 py-10">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">

            <div>

                <h2 class="text-2xl font-bold text-gray-800 mb-2">
                    Subscribe to our newsletter
                </h2>

                <p class="text-gray-500">
                    Get updates about new arrivals, discounts, and offers.
                </p>

            </div>

            <form class="flex flex-col sm:flex-row gap-3">

                <input
                    type="email"
                    placeholder="Enter your email"
                    class="flex-1 border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">

                <button
                    type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition whitespace-nowrap">

                    Subscribe

                </button>

            </form>

        </div>

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

<!-- =========================
     MOBILE MENU SCRIPT
========================= -->
<script>

    const mobileBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');

    mobileBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });

</script>

</body>
</html>
