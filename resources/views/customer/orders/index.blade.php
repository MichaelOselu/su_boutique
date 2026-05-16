@extends('shop.layout')

@section('content')

<div class="max-w-5xl mx-auto">

    <h1 class="text-2xl font-bold mb-6">
        My Orders
    </h1>

    @if($orders->count() == 0)

        <div class="bg-white p-6 rounded shadow text-center text-gray-500">
            You have no orders yet.
        </div>

    @else

        <div class="space-y-4">

            @foreach($orders as $order)

                <div class="bg-white p-4 rounded shadow flex justify-between items-center">

                    <div>

                        <h2 class="font-bold">
                            Order #{{ $order->id }}
                        </h2>

                        <p class="text-sm text-gray-500">
                            KSh {{ $order->total }} • {{ $order->created_at->format('d M Y') }}
                        </p>

                        <!-- STATUS BADGE -->
                        <span class="inline-block mt-2 px-3 py-1 text-xs rounded text-white
                            @if($order->status == 'paid') bg-green-600
                            @elseif($order->status == 'pending') bg-yellow-500
                            @elseif($order->status == 'shipped') bg-blue-500
                            @else bg-gray-500
                            @endif">

                            {{ strtoupper($order->status) }}
                        </span>

                    </div>

                    <a href="{{ route('orders.show', $order->id) }}"
                       class="bg-blue-600 text-white px-4 py-2 rounded">
                        View
                    </a>

                </div>

            @endforeach

        </div>

    @endif

</div>

@endsection
