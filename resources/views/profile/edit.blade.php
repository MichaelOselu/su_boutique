<x-app-layout>

    <x-slot name="header">
        <div class="max-w-7xl mx-auto px-4 flex items-center justify-between">

            <h2 class="text-2xl font-bold text-gray-800">
                My Account
            </h2>

            <a href="{{ route('shop') }}"
               class="text-sm text-blue-600 hover:underline font-medium">
                ← Continue Shopping
            </a>

        </div>
    </x-slot>

    <div class="bg-gray-100 min-h-screen py-6">

        <div class="max-w-7xl mx-auto px-4 space-y-6">

            <!-- =========================
                 ACCOUNT OVERVIEW (MATCH SHOP CARD STYLE)
            ========================= -->
            <div class="bg-white rounded-lg shadow p-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                <div>
                    <h3 class="text-xl font-semibold text-gray-800">
                        Welcome back, {{ auth()->user()->name }}
                    </h3>

                    <p class="text-gray-500 text-sm mt-1">
                        Manage your profile, orders, and security in one place.
                    </p>
                </div>

                <div class="flex flex-wrap gap-3">

                    <a href="{{ route('shop') }}"
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm transition">
                        Browse Products
                    </a>

                    <a href="{{ route('cart.index') }}"
                       class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-lg text-sm transition">
                        View Cart
                    </a>

                    <a href="{{ route('orders.my') }}"
                       class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm transition">
                        My Orders
                    </a>

                </div>
            </div>

            <!-- =========================
                 STATS (MATCH SHOP GRID STYLE)
            ========================= -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="bg-white rounded-lg shadow p-6">
                    <p class="text-gray-500 text-sm">Total Orders</p>
                    <p class="text-2xl font-bold text-gray-800 mt-2">
                        {{ auth()->user()->orders()->count() }}
                    </p>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <p class="text-gray-500 text-sm">Total Spent</p>
                    <p class="text-2xl font-bold text-gray-800 mt-2">
                        KSh {{ auth()->user()->orders()->sum('total') }}
                    </p>
                </div>

                <div class="bg-white rounded-lg shadow p-6">

                    <p class="text-gray-500 text-sm">Latest Order</p>

                    @php
                        $latest = auth()->user()->orders()->latest()->first();
                    @endphp

                    <p class="text-gray-800 font-bold mt-2">
                        @if($latest)
                            #{{ $latest->id }} ({{ strtoupper($latest->status) }})
                        @else
                            No orders yet
                        @endif
                    </p>

                </div>

            </div>

            <!-- =========================
                 PROFILE SECTION (SAME CARD STYLE AS SHOP)
            ========================= -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="font-semibold text-gray-800 mb-4">
                        Profile Information
                    </h3>
                    @include('profile.partials.update-profile-information-form')
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="font-semibold text-gray-800 mb-4">
                        Security
                    </h3>
                    @include('profile.partials.update-password-form')
                </div>

                <div class="bg-white rounded-lg shadow p-6 border border-red-100">
                    <h3 class="font-semibold text-red-600 mb-4">
                        Danger Zone
                    </h3>
                    @include('profile.partials.delete-user-form')
                </div>

            </div>

            <!-- =========================
                 RECENT ORDERS (MATCH SHOP LIST STYLE)
            ========================= -->
            <div class="bg-white rounded-lg shadow p-6">

                <div class="flex items-center justify-between mb-4">

                    <h3 class="font-semibold text-gray-800">
                        Recent Orders
                    </h3>

                    <a href="{{ route('orders.my') }}"
                       class="text-sm text-blue-600 hover:underline">
                        View All →
                    </a>

                </div>

                @php
                    $orders = auth()->user()->orders()->latest()->take(3)->get();
                @endphp

                @if($orders->count())

                    <div class="space-y-3">

                        @foreach($orders as $order)

                            <div class="flex items-center justify-between border-b pb-3">

                                <div>
                                    <p class="font-medium text-gray-800">
                                        Order #{{ $order->id }}
                                    </p>

                                    <p class="text-sm text-gray-500">
                                        KSh {{ number_format($order->total, 2) }}
                                    </p>
                                </div>

                                <span class="text-xs px-3 py-1 rounded-full text-white
                                    @if($order->status == 'paid') bg-green-600
                                    @elseif($order->status == 'pending') bg-yellow-500
                                    @else bg-gray-500
                                    @endif">

                                    {{ strtoupper($order->status) }}
                                </span>

                            </div>

                        @endforeach

                    </div>

                @else

                    <p class="text-gray-500 text-sm">
                        You have no orders yet.
                    </p>

                @endif

            </div>

        </div>

    </div>

</x-app-layout>
