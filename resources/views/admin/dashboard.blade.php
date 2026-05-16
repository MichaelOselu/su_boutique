@extends('admin.layout')

@section('content')

<div class="space-y-6 sm:space-y-8 px-3 sm:px-0">

    <!-- PAGE HEADER -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <div>

            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">
                Dashboard Overview
            </h1>

            <p class="text-gray-500 mt-1 text-sm sm:text-base">
                Welcome back, {{ auth()->user()->name }}
            </p>

        </div>

        <!-- QUICK ACTIONS -->
        <div class="flex flex-col sm:flex-row flex-wrap gap-3">

            <a href="{{ route('admin.products.create') }}"
               class="w-full sm:w-auto text-center bg-blue-600 hover:bg-blue-700 text-white px-4 sm:px-5 py-2 sm:py-3 rounded-xl shadow transition text-sm sm:text-base">

                + Add Product

            </a>

            <a href="{{ route('admin.categories.create') }}"
               class="w-full sm:w-auto text-center bg-gray-800 hover:bg-black text-white px-4 sm:px-5 py-2 sm:py-3 rounded-xl shadow transition text-sm sm:text-base">

                + Add Category

            </a>

        </div>

    </div>

    <!-- STATS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">

        <!-- PRODUCTS -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 sm:p-6">

            <div class="flex items-center justify-between">

                <div class="min-w-0">

                    <p class="text-xs sm:text-sm text-gray-500">
                        Products
                    </p>

                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mt-2">
                        {{ $totalProducts }}
                    </h2>

                </div>

                <div class="text-3xl sm:text-4xl flex-shrink-0">
                    📦
                </div>

            </div>

        </div>

        <!-- CATEGORIES -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 sm:p-6">

            <div class="flex items-center justify-between">

                <div class="min-w-0">

                    <p class="text-xs sm:text-sm text-gray-500">
                        Categories
                    </p>

                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mt-2">
                        {{ $totalCategories }}
                    </h2>

                </div>

                <div class="text-3xl sm:text-4xl flex-shrink-0">
                    🗂
                </div>

            </div>

        </div>

        <!-- USERS -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 sm:p-6">

            <div class="flex items-center justify-between">

                <div class="min-w-0">

                    <p class="text-xs sm:text-sm text-gray-500">
                        Users
                    </p>

                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mt-2">
                        {{ $totalUsers }}
                    </h2>

                </div>

                <div class="text-3xl sm:text-4xl flex-shrink-0">
                    👥
                </div>

            </div>

        </div>

        <!-- REVENUE -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 sm:p-6">

            <div class="flex items-center justify-between">

                <div class="min-w-0">

                    <p class="text-xs sm:text-sm text-gray-500">
                        Revenue
                    </p>

                    <h2 class="text-2xl sm:text-3xl font-bold text-green-600 mt-2">
                        KSh {{ number_format($totalRevenue ?? 0, 2) }}
                    </h2>

                </div>

                <div class="text-3xl sm:text-4xl flex-shrink-0">
                    💰
                </div>

            </div>

        </div>

    </div>

    <!-- SECOND SECTION -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-4 sm:gap-6">

        <!-- RECENT PRODUCTS -->
        <div class="xl:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            <div class="p-4 sm:p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

                <div>

                    <h2 class="text-lg sm:text-xl font-bold text-gray-800">
                        Recent Products
                    </h2>

                    <p class="text-xs sm:text-sm text-gray-500 mt-1">
                        Latest products added to the store
                    </p>

                </div>

                <a href="{{ route('admin.products.index') }}"
                   class="text-blue-600 hover:text-blue-700 text-sm font-semibold self-start sm:self-auto">

                    View All

                </a>

            </div>

            <div class="divide-y divide-gray-100">

                @forelse($recentProducts ?? [] as $product)

                    <div class="p-4 sm:p-5 flex items-center justify-between gap-3">

                        <div class="flex items-center gap-3 sm:gap-4 min-w-0">

                            @if($product->image)

                                <img src="{{ asset('storage/' . $product->image) }}"
                                     class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl object-cover border flex-shrink-0">

                            @else

                                <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl bg-gray-200 flex items-center justify-center flex-shrink-0">
                                    📦
                                </div>

                            @endif

                            <div class="min-w-0">

                                <h3 class="font-semibold text-gray-800 text-sm sm:text-base truncate">
                                    {{ $product->name }}
                                </h3>

                                <p class="text-xs sm:text-sm text-gray-500">
                                    KSh {{ number_format($product->price, 2) }}
                                </p>

                            </div>

                        </div>

                        <!-- STOCK -->
                        <div class="flex-shrink-0">

                            @if($product->stock_quantity < 5)

                                <span class="bg-red-100 text-red-600 px-2 sm:px-3 py-1 rounded-full text-[10px] sm:text-xs font-bold whitespace-nowrap">
                                    Low Stock
                                </span>

                            @else

                                <span class="bg-green-100 text-green-600 px-2 sm:px-3 py-1 rounded-full text-[10px] sm:text-xs font-bold whitespace-nowrap">
                                    In Stock
                                </span>

                            @endif

                        </div>

                    </div>

                @empty

                    <div class="p-6 text-center text-gray-500 text-sm">
                        No products found
                    </div>

                @endforelse

            </div>

        </div>

        <!-- QUICK INFO -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100">

            <div class="p-4 sm:p-6 border-b border-gray-100">

                <h2 class="text-lg sm:text-xl font-bold text-gray-800">
                    Store Insights
                </h2>

                <p class="text-xs sm:text-sm text-gray-500 mt-1">
                    Ecommerce quick overview
                </p>

            </div>

            <div class="p-4 sm:p-6 space-y-4 sm:space-y-5 text-sm sm:text-base">

                <div class="flex items-center justify-between">
                    <span class="text-gray-600">Flash Sale Products</span>
                    <span class="font-bold text-red-500">{{ $flashSalesCount ?? 0 }}</span>
                </div>

                <div class="flex items-center justify-between">
                    <span class="text-gray-600">Low Stock Products</span>
                    <span class="font-bold text-orange-500">{{ $lowStockCount ?? 0 }}</span>
                </div>

                <div class="flex items-center justify-between">
                    <span class="text-gray-600">Active Categories</span>
                    <span class="font-bold text-blue-500">{{ $totalCategories }}</span>
                </div>

                <div class="flex items-center justify-between">
                    <span class="text-gray-600">Total Customers</span>
                    <span class="font-bold text-green-500">{{ $totalUsers }}</span>
                </div>

            </div>

        </div>

    </div>

</div>

@endsection
