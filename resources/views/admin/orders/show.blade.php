@extends('admin.layout')

@section('content')

<div class="space-y-6">

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Order #{{ $order->id }}
            </h1>

            <p class="text-gray-500 mt-1">
                Full order details and management
            </p>
        </div>

    </div>

    <!-- TOP GRID -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- CUSTOMER INFO -->
        <div class="bg-white rounded-2xl shadow-sm border p-5 space-y-2">

            <h2 class="font-bold text-gray-800 border-b pb-2">
                Customer Info
            </h2>

            <p><span class="text-gray-500">Name:</span> {{ $order->name }}</p>
            <p><span class="text-gray-500">Email:</span> {{ $order->email }}</p>
            <p><span class="text-gray-500">Phone:</span> {{ $order->phone }}</p>
            <p><span class="text-gray-500">Address:</span> {{ $order->address }}</p>

        </div>

        <!-- ORDER SUMMARY -->
        <div class="bg-white rounded-2xl shadow-sm border p-5 space-y-3">

            <h2 class="font-bold text-gray-800 border-b pb-2">
                Order Summary
            </h2>

            <p>
                <span class="text-gray-500">Total:</span>
                <span class="font-bold text-gray-800">
                    KSh {{ number_format($order->total, 2) }}
                </span>
            </p>

            <p>
                <span class="text-gray-500">Items:</span>
                <span class="font-bold">
                    {{ $order->items->count() }}
                </span>
            </p>

            <!-- STATUS BADGE -->
            <div class="pt-2">

                @if($order->status == 'pending')
                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm font-semibold">
                        Pending
                    </span>

                @elseif($order->status == 'shipped')
                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-semibold">
                        Shipped
                    </span>

                @else
                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">
                        Delivered
                    </span>
                @endif

            </div>

        </div>

        <!-- UPDATE STATUS -->
        <div class="bg-white rounded-2xl shadow-sm border p-5">

            <h2 class="font-bold text-gray-800 border-b pb-2 mb-4">
                Update Status
            </h2>

            <form method="POST"
                  action="{{ route('admin.orders.updateStatus', $order->id) }}"
                  class="space-y-4">

                @csrf

                <select name="status"
                        class="w-full border rounded-xl p-3 focus:ring-2 focus:ring-blue-500">

                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>
                        Pending
                    </option>

                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>
                        Shipped
                    </option>

                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>
                        Delivered
                    </option>

                </select>

                <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl transition">

                    Update Status

                </button>

            </form>

        </div>

    </div>

    <!-- ITEMS SECTION -->
    <div class="bg-white rounded-2xl shadow-sm border overflow-hidden">

        <div class="p-5 border-b">
            <h2 class="text-lg font-bold text-gray-800">
                Order Items
            </h2>
        </div>

        <!-- DESKTOP TABLE -->
        <div class="hidden md:block overflow-x-auto">

            <table class="w-full">

                <thead class="bg-gray-50 text-left text-sm text-gray-600">

                    <tr>
                        <th class="p-4">Product</th>
                        <th class="p-4">Price</th>
                        <th class="p-4">Qty</th>
                        <th class="p-4">Subtotal</th>
                    </tr>

                </thead>

                <tbody class="divide-y">

                    @foreach($order->items as $item)

                        <tr>

                            <td class="p-4 font-medium">
                                {{ $item->product_id }}
                            </td>

                            <td class="p-4">
                                KSh {{ number_format($item->price, 2) }}
                            </td>

                            <td class="p-4">
                                {{ $item->quantity }}
                            </td>

                            <td class="p-4 font-bold">
                                KSh {{ number_format($item->subtotal, 2) }}
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

        <!-- MOBILE CARDS -->
        <div class="md:hidden divide-y">

            @foreach($order->items as $item)

                <div class="p-4 space-y-2">

                    <p class="font-bold">
                        Product ID: {{ $item->product_id }}
                    </p>

                    <p>Price: KSh {{ number_format($item->price, 2) }}</p>
                    <p>Qty: {{ $item->quantity }}</p>

                    <p class="font-bold text-gray-800">
                        Subtotal: KSh {{ number_format($item->subtotal, 2) }}
                    </p>

                </div>

            @endforeach

        </div>

    </div>

</div>

@endsection
