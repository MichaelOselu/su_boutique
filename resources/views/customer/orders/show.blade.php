@extends('shop.layout')

@section('content')

<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">

    <h1 class="text-2xl font-bold mb-4">
        Order #{{ $order->id }}
    </h1>

    <!-- TIMELINE -->
    <div class="space-y-4 border-l-2 border-gray-300 pl-4">

        @php
            $steps = [
                'pending' => 'Order Placed',
                'paid' => 'Payment Confirmed',
                'processing' => 'Processing',
                'shipped' => 'Shipped',
                'delivered' => 'Delivered'
            ];

            $activeFound = false;
        @endphp

        @foreach($steps as $key => $label)

            <div class="relative">

                <div class="absolute -left-3 top-1 w-2 h-2 rounded-full
                    {{ $order->status == $key ? 'bg-green-600' : 'bg-gray-400' }}">
                </div>

                <p class="{{ $order->status == $key ? 'font-bold text-green-600' : 'text-gray-500' }}">
                    {{ $label }}
                </p>

            </div>

        @endforeach

    </div>

    <!-- ORDER ITEMS -->
    <h2 class="mt-6 font-bold text-lg">Items</h2>

    <div class="mt-3 space-y-2">

        @foreach($order->items as $item)

            <div class="flex justify-between border-b pb-2">

                <div>
                    {{ $item->product->name }}
                    <p class="text-sm text-gray-500">Qty: {{ $item->quantity }}</p>
                </div>

                <div>
                    KSh {{ $item->subtotal }}
                </div>

            </div>

        @endforeach

    </div>

</div>

@endsection
