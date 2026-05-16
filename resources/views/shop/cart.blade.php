@extends('shop.layout')

@section('content')

<div class="max-w-6xl mx-auto px-4 sm:px-0">

    <!-- PAGE TITLE -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-6">

        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">
            Shopping Cart
        </h1>

        <a href="{{ route('shop') }}"
           class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow text-center">
            Continue Shopping
        </a>

    </div>

    <!-- SUCCESS MESSAGE -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- ERROR MESSAGE -->
    @if(session('error'))
        <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- =========================
         MOBILE VIEW (CARDS)
    ========================= -->
    <div class="sm:hidden space-y-4">

        @forelse($cart as $id => $item)

            <div class="bg-white rounded-xl shadow p-4">

                <div class="flex gap-4">

                    @if($item['image'])
                        <img src="{{ asset('storage/' . $item['image']) }}"
                             class="w-24 h-24 object-cover rounded-lg border">
                    @endif

                    <div class="flex-1">

                        <h2 class="font-semibold text-gray-800 text-lg">
                            {{ $item['name'] }}
                        </h2>

                        <p class="text-gray-600 mt-1">
                            KSh {{ number_format($item['price']) }}
                        </p>

                        <p class="text-sm text-gray-500 mt-1">
                            Subtotal: <span class="font-bold text-gray-700">
                                KSh {{ number_format($item['price'] * $item['quantity']) }}
                            </span>
                        </p>

                    </div>

                </div>

                <!-- UPDATE + REMOVE -->
                <div class="mt-4 flex items-center justify-between gap-2">

                    <form method="POST"
                          action="{{ route('cart.update', $id) }}"
                          class="flex items-center gap-2 w-full">

                        @csrf

                        <input type="number"
                               name="quantity"
                               value="{{ $item['quantity'] }}"
                               min="1"
                               class="w-20 border rounded-lg px-2 py-1">

                        <button class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg text-sm">
                            Update
                        </button>

                    </form>

                </div>

                <form method="POST"
                      action="{{ route('cart.remove', $id) }}"
                      class="mt-2">

                    @csrf

                    <button class="w-full bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg">
                        Remove Item
                    </button>

                </form>

            </div>

        @empty

            <div class="bg-white p-6 text-center rounded-lg shadow">

                <p class="text-xl mb-4">Your cart is empty</p>

                <a href="{{ route('shop') }}"
                   class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-3 rounded-lg">
                    Start Shopping
                </a>

            </div>

        @endforelse

    </div>

    <!-- =========================
         DESKTOP TABLE VIEW
    ========================= -->
    <div class="hidden sm:block bg-white shadow-lg rounded-xl overflow-x-auto">

        <table class="w-full min-w-[700px]">

            <thead class="bg-gray-100">

                <tr>
                    <th class="p-4 text-left">Product</th>
                    <th class="p-4 text-left">Price</th>
                    <th class="p-4 text-left">Quantity</th>
                    <th class="p-4 text-left">Subtotal</th>
                    <th class="p-4 text-left">Action</th>
                </tr>

            </thead>

            <tbody>

            @forelse($cart as $id => $item)

                <tr class="border-t hover:bg-gray-50 transition">

                    <!-- PRODUCT -->
                    <td class="p-4">

                        <div class="flex items-center gap-4">

                            @if($item['image'])
                                <img src="{{ asset('storage/' . $item['image']) }}"
                                     class="w-20 h-20 object-cover rounded-lg border">
                            @endif

                            <div>
                                <h2 class="font-semibold text-lg text-gray-800">
                                    {{ $item['name'] }}
                                </h2>
                            </div>

                        </div>

                    </td>

                    <!-- PRICE -->
                    <td class="p-4 font-medium text-gray-700">
                        KSh {{ number_format($item['price']) }}
                    </td>

                    <!-- QUANTITY -->
                    <td class="p-4">

                        <form method="POST"
                              action="{{ route('cart.update', $id) }}"
                              class="flex items-center gap-2">

                            @csrf

                            <input type="number"
                                   name="quantity"
                                   value="{{ $item['quantity'] }}"
                                   min="1"
                                   class="w-20 border rounded-lg px-3 py-2">

                            <button class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg">
                                Update
                            </button>

                        </form>

                    </td>

                    <!-- SUBTOTAL -->
                    <td class="p-4 font-bold text-gray-800">
                        KSh {{ number_format($item['price'] * $item['quantity']) }}
                    </td>

                    <!-- REMOVE -->
                    <td class="p-4">

                        <form method="POST"
                              action="{{ route('cart.remove', $id) }}">

                            @csrf

                            <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg">
                                Remove
                            </button>

                        </form>

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="5" class="p-10 text-center text-gray-500">
                        Your cart is empty
                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

    <!-- TOTAL + CHECKOUT -->
    @if(count($cart) > 0)

    <div class="mt-6 flex flex-col sm:flex-row justify-between items-center bg-white shadow-lg rounded-xl p-6 gap-4">

        <h2 class="text-xl sm:text-2xl font-bold text-gray-800">
            Total: KSh {{ number_format($total) }}
        </h2>

        <a href="{{ route('checkout.index') }}"
           class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg text-lg shadow w-full sm:w-auto text-center">
            Proceed to Checkout
        </a>

    </div>

    @endif

</div>

@endsection
