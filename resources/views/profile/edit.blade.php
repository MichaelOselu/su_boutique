<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800">
                My Account
            </h2>

            <a href="{{ route('shop') }}"
               class="text-sm text-blue-600 hover:underline">
                ← Continue Shopping
            </a>
        </div>
    </x-slot>

    <div class="py-10 bg-gray-100 min-h-screen">

        <div class="max-w-6xl mx-auto px-4 space-y-6">

            <!-- ACCOUNT OVERVIEW -->
            <div class="bg-white shadow rounded-lg p-6 flex flex-col md:flex-row md:items-center md:justify-between">

                <div>
                    <h3 class="text-xl font-semibold text-gray-800">
                        Welcome back, {{ auth()->user()->name }}
                    </h3>

                    <p class="text-gray-500 text-sm mt-1">
                        Manage your profile, orders, and security in one place.
                    </p>
                </div>

                <div class="mt-4 md:mt-0 flex gap-3">

                    <a href="{{ route('shop') }}"
                       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
                        Browse Products
                    </a>

                    <a href="{{ route('cart.index') }}"
                       class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-900 text-sm">
                        View Cart
                    </a>

                    <a href="{{ route('orders.my') }}"
                       class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 text-sm">
                        My Orders
                    </a>

                </div>
            </div>

            <!-- STATS SECTION -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- TOTAL ORDERS -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h4 class="text-gray-500 text-sm">Total Orders</h4>
                    <p class="text-2xl font-bold text-gray-800 mt-2">
                        {{ auth()->user()->orders()->count() }}
                    </p>
                </div>

                <!-- TOTAL SPENT -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h4 class="text-gray-500 text-sm">Total Spent</h4>
                    <p class="text-2xl font-bold text-gray-800 mt-2">
                        KSh {{ auth()->user()->orders()->sum('total') }}
                    </p>
                </div>

                <!-- LATEST ORDER -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h4 class="text-gray-500 text-sm">Latest Order</h4>

                    @php
                        $latest = auth()->user()->orders()->latest()->first();
                    @endphp

                    <p class="text-gray-800 font-bold mt-2">
                        @if($latest)
                            #{{ $latest->id }} ({{ $latest->status }})
                        @else
                            No orders yet
                        @endif
                    </p>
                </div>

            </div>

            <!-- PROFILE MANAGEMENT -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- PROFILE INFO -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="font-semibold text-gray-800 mb-4">
                        Profile Information
                    </h3>

                    @include('profile.partials.update-profile-information-form')
                </div>

                <!-- PASSWORD -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="font-semibold text-gray-800 mb-4">
                        Security
                    </h3>

                    @include('profile.partials.update-password-form')
                </div>

                <!-- DELETE ACCOUNT -->
                <div class="bg-white shadow rounded-lg p-6 border border-red-100">
                    <h3 class="font-semibold text-red-600 mb-4">
                        Danger Zone
                    </h3>

                    @include('profile.partials.delete-user-form')
                </div>

            </div>

            <!-- ORDER PREVIEW SECTION -->
            <div class="bg-white shadow rounded-lg p-6">

                <div class="flex justify-between items-center mb-4">
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

                            <div class="flex justify-between border-b pb-2">

                                <div>
                                    <p class="font-medium">Order #{{ $order->id }}</p>
                                    <p class="text-sm text-gray-500">
                                        KSh {{ $order->total }}
                                    </p>
                                </div>

                                <span class="text-sm px-2 py-1 rounded text-white
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
