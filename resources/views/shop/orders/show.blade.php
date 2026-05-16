@extends('shop.layout')

@section('content')

<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">

    <h1 class="text-2xl font-bold mb-4">
        Order #{{ $order->id }}
    </h1>

    <p class="mb-4 text-gray-600">
        Status:
        <span class="font-bold">
            {{ strtoupper($order->status) }}
        </span>
    </p>

    <div class="border rounded p-4 mb-6">

        <p><strong>Name:</strong> {{ $order->name }}</p>
        <p><strong>Phone:</strong> {{ $order->phone }}</p>
        <p><strong>Email:</strong> {{ $order->email }}</p>
        <p><strong>Address:</strong> {{ $order->address }}</p>

    </div>

    <h2 class="text-xl font-bold mb-3">Items</h2>

    <div class="space-y-3">

        @foreach($order->items as $item)

            <div class="flex justify-between border-b pb-2">

                <div>
                    <p class="font-medium">
                        {{ $item->product->name }}
                    </p>

                    <p class="text-sm text-gray-500">
                        Qty: {{ $item->quantity }}
                    </p>
                </div>

                <div class="font-bold">
                    KSh {{ $item->subtotal }}
                </div>

            </div>

        @endforeach

    </div>

</div>

@endsection
