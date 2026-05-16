@extends('admin.layout')

@section('content')

<div class="max-w-7xl mx-auto px-4 py-6 space-y-6">

    <!-- PAGE HEADER -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

        <div>

            <h1 class="text-3xl font-bold text-gray-800">
                Dashboard Overview
            </h1>

            <p class="text-gray-500 mt-1">
                Welcome back, {{ auth()->user()->name }}
            </p>

        </div>

        <!-- ACTION BUTTONS -->
        <div class="flex flex-col sm:flex-row gap-3">

            <a href="{{ route('admin.products.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg transition font-semibold text-center shadow">

                + Add Product

            </a>

            <a href="{{ route('admin.categories.create') }}"
               class="bg-gray-800 hover:bg-black text-white px-5 py-3 rounded-lg transition font-semibold text-center shadow">

                + Add Category

            </a>

        </div>

    </div>

    <!-- STATS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">

        <!-- PRODUCTS -->
        <div class="bg-white rounded-lg shadow-lg p-6 border border-gray-100 hover:shadow-xl transition">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-gray-500 text-sm">
                        Products
                    </p>

                    <h2 class="text-3xl font-bold text-gray-800 mt-2">
                        {{ $totalProducts }}
                    </h2>

                </div>

                <div class="text-4xl">
                    📦
                </div>

            </div>

        </div>

        <!-- CATEGORIES -->
        <div class="bg-white rounded-lg shadow-lg p-6 border border-gray-100 hover:shadow-xl transition">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-gray-500 text-sm">
                        Categories
                    </p>

                    <h2 class="text-3xl font-bold text-gray-800 mt-2">
                        {{ $totalCategories }}
                    </h2>

                </div>

                <div class="text-4xl">
                    🗂
                </div>

            </div>

        </div>

        <!-- USERS -->
        <div class="bg-white rounded-lg shadow-lg p-6 border border-gray-100 hover:shadow-xl transition">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-gray-500 text-sm">
                        Users
                    </p>

                    <h2 class="text-3xl font-bold text-gray-800 mt-2">
                        {{ $totalUsers }}
                    </h2>

                </div>

                <div class="text-4xl">
                    👥
                </div>

            </div>

        </div>

        <!-- REVENUE -->
        <div class="bg-white rounded-lg shadow-lg p-6 border border-gray-100 hover:shadow-xl transition">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-gray-500 text-sm">
                        Revenue
                    </p>

                    <h2 class="text-3xl font-bold text-green-600 mt-2">
                        KSh {{ number_format($totalRevenue ?? 0, 2) }}
                    </h2>

                </div>

                <div class="text-4xl">
                    💰
                </div>

            </div>

        </div>

    </div>

    <!-- SECOND SECTION -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        <!-- RECENT PRODUCTS -->
        <div class="xl:col-span-2 bg-white rounded-lg shadow-lg border border-gray-100 overflow-hidden">

            <!-- HEADER -->
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">

                <div>

                    <h2 class="text-xl font-bold text-gray-800">
                        Recent Products
                    </h2>

                    <p class="text-gray-500 text-sm mt-1">
                        Latest products added to the store
                    </p>

                </div>

                <a href="{{ route('admin.products.index') }}"
                   class="text-blue-600 hover:text-blue-700 font-semibold text-sm">

                    View All

                </a>

            </div>

            <!-- PRODUCTS -->
            <div class="divide-y divide-gray-100">

                @forelse($recentProducts ?? [] as $product)

                    <div class="p-5 flex items-center justify-between gap-4 hover:bg-gray-50 transition">

                        <div class="flex items-center gap-4 min-w-0">

                            @if($product->image)

                                <img src="{{ asset('uploads/products/' . $product->image) }}"
                                     class="w-14 h-14 rounded-lg object-cover border border-gray-200 flex-shrink-0">

                            @else

                                <div class="w-14 h-14 rounded-lg bg-gray-200 flex items-center justify-center flex-shrink-0">
                                    📦
                                </div>

                            @endif

                            <div class="min-w-0">

                                <h3 class="font-semibold text-gray-800 truncate">
                                    {{ $product->name }}
                                </h3>

                                <p class="text-sm text-gray-500 mt-1">
                                    KSh {{ number_format($product->price, 2) }}
                                </p>

                            </div>

                        </div>

                        <!-- STOCK -->
                        <div>

                            @if($product->stock_quantity < 5)

                                <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs font-bold">
                                    Low Stock
                                </span>

                            @else

                                <span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-xs font-bold">
                                    In Stock
                                </span>

                            @endif

                        </div>

                    </div>

                @empty

                    <div class="p-10 text-center">

                        <p class="text-gray-500">
                            No products found.
                        </p>

                    </div>

                @endforelse

            </div>

        </div>

        <!-- STORE INSIGHTS -->
        <div class="bg-white rounded-lg shadow-lg border border-gray-100 overflow-hidden">

            <!-- HEADER -->
            <div class="p-6 border-b border-gray-100">

                <h2 class="text-xl font-bold text-gray-800">
                    Store Insights
                </h2>

                <p class="text-gray-500 text-sm mt-1">
                    Ecommerce quick overview
                </p>

            </div>

            <!-- CONTENT -->
            <div class="p-6 space-y-5">

                <div class="flex items-center justify-between">

                    <span class="text-gray-600">
                        Flash Sale Products
                    </span>

                    <span class="font-bold text-red-500">
                        {{ $flashSalesCount ?? 0 }}
                    </span>

                </div>

                <div class="flex items-center justify-between">

                    <span class="text-gray-600">
                        Low Stock Products
                    </span>

                    <span class="font-bold text-orange-500">
                        {{ $lowStockCount ?? 0 }}
                    </span>

                </div>

                <div class="flex items-center justify-between">

                    <span class="text-gray-600">
                        Active Categories
                    </span>

                    <span class="font-bold text-blue-500">
                        {{ $totalCategories }}
                    </span>

                </div>

                <div class="flex items-center justify-between">

                    <span class="text-gray-600">
                        Total Customers
                    </span>

                    <span class="font-bold text-green-500">
                        {{ $totalUsers }}
                    </span>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
