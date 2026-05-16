@extends('shop.layout')

@section('content')

<div class="max-w-5xl mx-auto bg-white p-6 rounded shadow">

    <h1 class="text-2xl font-bold mb-6">My Orders</h1>

    @if($orders->count() == 0)
        <p>No orders yet.</p>
    @endif

    <div class="space-y-4">

        @foreach($orders as $order)

            <a href="{{ route('orders.show', $order->id) }}"
               class="block border p-4 rounded hover:bg-gray-50">

                <div class="flex justify-between">

                    <div>
                        <p class="font-bold">Order #{{ $order->id }}</p>
                        <p class="text-sm text-gray-500">
                            {{ $order->created_at->format('d M Y') }}
                        </p>
                    </div>

                    <div class="text-right">

                        <p class="font-bold">KSh {{ $order->total }}</p>

                        <span class="text-sm px-2 py-1 rounded text-white
                            {{ $order->status == 'paid' ? 'bg-green-600' : 'bg-yellow-500' }}">
                            {{ strtoupper($order->status) }}
                        </span>

                    </div>

                </div>

            </a>

        @endforeach

    </div>

</div>

@endsection
