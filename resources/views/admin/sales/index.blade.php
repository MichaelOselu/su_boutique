@extends('admin.layout')

@section('content')

<div class="space-y-6">

    <!-- HEADER -->
    <div>
        <h1 class="text-3xl font-bold text-gray-800">
            Sales Overview
        </h1>

        <p class="text-gray-500 mt-1">
            Revenue and performance analytics
        </p>
    </div>

    <!-- METRICS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        <div class="bg-green-50 p-6 rounded-2xl">
            <p class="text-green-700 text-sm">Total Revenue</p>
            <p class="text-3xl font-bold text-green-700">
                KSh {{ number_format($totalRevenue, 2) }}
            </p>
        </div>

        <div class="bg-blue-50 p-6 rounded-2xl">
            <p class="text-blue-700 text-sm">Total Orders</p>
            <p class="text-3xl font-bold text-blue-700">
                {{ $totalOrders }}
            </p>
        </div>

        <div class="bg-purple-50 p-6 rounded-2xl">
            <p class="text-purple-700 text-sm">Average Order Value</p>
            <p class="text-3xl font-bold text-purple-700">
                KSh {{ number_format($averageOrderValue, 2) }}
            </p>
        </div>

    </div>

    <!-- RECENT SALES -->
    <div class="bg-white rounded-2xl shadow-sm border overflow-hidden">

        <div class="p-5 border-b">
            <h2 class="font-bold text-lg">
                Recent Orders
            </h2>
        </div>

        <table class="w-full">

            <thead class="bg-gray-50 text-left text-sm text-gray-600">
                <tr>
                    <th class="p-4">Order</th>
                    <th class="p-4">Customer</th>
                    <th class="p-4">Total</th>
                    <th class="p-4">Date</th>
                </tr>
            </thead>

            <tbody class="divide-y">

                @foreach($recentOrders as $order)

                    <tr>

                        <td class="p-4 font-bold">
                            #{{ $order->id }}
                        </td>

                        <td class="p-4">
                            {{ $order->name }}
                        </td>

                        <td class="p-4 font-bold">
                            KSh {{ number_format($order->total, 2) }}
                        </td>

                        <td class="p-4 text-gray-500">
                            {{ $order->created_at->format('d M Y') }}
                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

@endsection
