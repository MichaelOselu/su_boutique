@extends('admin.layout')

@section('content')

<div class="space-y-6">

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Orders
            </h1>

            <p class="text-gray-500 mt-1">
                Manage customer orders and payments
            </p>
        </div>

    </div>

    <!-- TABLE WRAPPER -->
    <div class="bg-white shadow-sm rounded-2xl overflow-hidden border border-gray-100">

        <!-- TABLE HEADER -->
        <div class="p-5 border-b border-gray-100">
            <h2 class="text-lg font-bold text-gray-800">
                All Orders
            </h2>
        </div>

        <!-- DESKTOP TABLE -->
        <div class="hidden md:block overflow-x-auto">

            <table class="w-full">

                <thead class="bg-gray-50 text-left text-sm text-gray-600">

                    <tr>
                        <th class="p-4">Order ID</th>
                        <th class="p-4">Customer</th>
                        <th class="p-4">Total</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-right">Action</th>
                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-100">

                    @foreach($orders as $order)

                        <tr class="hover:bg-gray-50 transition">

                            <!-- ORDER ID -->
                            <td class="p-4 font-semibold text-gray-800">
                                #{{ $order->id }}
                            </td>

                            <!-- CUSTOMER -->
                            <td class="p-4">
                                <div>
                                    <p class="font-medium text-gray-800">
                                        {{ $order->name }}
                                    </p>

                                    <p class="text-sm text-gray-500">
                                        {{ $order->email }}
                                    </p>
                                </div>
                            </td>

                            <!-- TOTAL -->
                            <td class="p-4 font-bold text-gray-800">
                                KSh {{ number_format($order->total, 2) }}
                            </td>

                            <!-- STATUS -->
                            <td class="p-4">

                                @if($order->status == 'pending')
                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        Pending
                                    </span>

                                @elseif($order->status == 'shipped')
                                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        Shipped
                                    </span>

                                @else
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        Delivered
                                    </span>
                                @endif

                            </td>

                            <!-- ACTION -->
                            <td class="p-4 text-right">

                                <a href="{{ route('admin.orders.show', $order->id) }}"
                                   class="bg-gray-900 hover:bg-black text-white px-4 py-2 rounded-lg text-sm transition">

                                    View

                                </a>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

        <!-- MOBILE CARDS -->
        <div class="md:hidden divide-y divide-gray-100">

            @foreach($orders as $order)

                <div class="p-5 space-y-3">

                    <div class="flex justify-between items-start">

                        <div>
                            <p class="font-bold text-gray-800">#{{ $order->id }}</p>
                            <p class="text-sm text-gray-500">{{ $order->name }}</p>
                            <p class="text-xs text-gray-400">{{ $order->email }}</p>
                        </div>

                        <div class="text-right">

                            <p class="font-bold text-gray-800">
                                KSh {{ number_format($order->total, 2) }}
                            </p>

                            @if($order->status == 'pending')
                                <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs">
                                    Pending
                                </span>

                            @elseif($order->status == 'shipped')
                                <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs">
                                    Shipped
                                </span>

                            @else
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs">
                                    Delivered
                                </span>
                            @endif

                        </div>

                    </div>

                    <a href="{{ route('admin.orders.show', $order->id) }}"
                       class="block text-center bg-gray-900 text-white py-2 rounded-lg">

                        View Order

                    </a>

                </div>

            @endforeach

        </div>

    </div>

</div>

@endsection
