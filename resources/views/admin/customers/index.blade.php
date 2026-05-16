@extends('admin.layout')

@section('content')

<div class="space-y-6">

    <!-- HEADER -->
    <div>
        <h1 class="text-3xl font-bold text-gray-800">
            Customers
        </h1>

        <p class="text-gray-500 mt-1">
            All registered customers and their activity
        </p>
    </div>

    <!-- STATS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        <div class="bg-white p-5 rounded-2xl shadow-sm">
            <p class="text-gray-500 text-sm">Total Customers</p>
            <p class="text-2xl font-bold">{{ $totalCustomers }}</p>
        </div>

        <div class="bg-green-50 p-5 rounded-2xl">
            <p class="text-green-700 text-sm">Active Customers</p>
            <p class="text-2xl font-bold text-green-700">{{ $activeCustomers }}</p>
        </div>

        <div class="bg-blue-50 p-5 rounded-2xl">
            <p class="text-blue-700 text-sm">Customers with Orders</p>
            <p class="text-2xl font-bold text-blue-700">{{ $customersWithOrders }}</p>
        </div>

    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden border">

        <div class="p-5 border-b">
            <h2 class="font-bold text-lg">All Customers</h2>
        </div>

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-gray-50 text-left text-sm text-gray-600">
                    <tr>
                        <th class="p-4">Name</th>
                        <th class="p-4">Email</th>
                        <th class="p-4">Orders</th>
                        <th class="p-4">Joined</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    @foreach($customers as $customer)

                        <tr class="hover:bg-gray-50">

                            <td class="p-4 font-medium">
                                {{ $customer->name }}
                            </td>

                            <td class="p-4 text-gray-600">
                                {{ $customer->email }}
                            </td>

                            <td class="p-4 font-bold">
                                {{ $customer->orders_count }}
                            </td>

                            <td class="p-4 text-gray-500">
                                {{ $customer->created_at->format('d M Y') }}
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
