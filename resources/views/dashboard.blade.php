@extends('shop.layout')

@section('content')

<div class="max-w-6xl mx-auto">

    <h1 class="text-2xl font-bold mb-6">
        Customer Dashboard
    </h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- PROFILE CARD -->
        <div class="bg-white p-6 rounded shadow">

            <h2 class="font-bold mb-3">Profile</h2>

            <p><strong>Name:</strong> {{ auth()->user()->name }}</p>
            <p><strong>Email:</strong> {{ auth()->user()->email }}</p>

            <a href="{{ route('profile.edit') }}"
               class="text-blue-600 mt-3 inline-block">
                Edit Profile
            </a>

        </div>

        <!-- ORDERS SUMMARY -->
        <div class="bg-white p-6 rounded shadow">

            <h2 class="font-bold mb-3">Orders</h2>

            @php
                $ordersCount = \App\Models\Order::where('user_id', auth()->id())->count();
            @endphp

            <p class="text-3xl font-bold">{{ $ordersCount }}</p>

            <a href="{{ route('orders.my') }}"
               class="text-blue-600 mt-3 inline-block">
                View Orders
            </a>

        </div>

        <!-- QUICK ACTIONS -->
        <div class="bg-white p-6 rounded shadow">

            <h2 class="font-bold mb-3">Quick Actions</h2>

            <ul class="space-y-2 text-blue-600">

                <li><a href="{{ route('shop') }}">Browse Products</a></li>
                <li><a href="{{ route('cart.index') }}">View Cart</a></li>
                <li><a href="{{ route('orders.my') }}">Track Orders</a></li>

            </ul>

        </div>

    </div>

</div>

@endsection
