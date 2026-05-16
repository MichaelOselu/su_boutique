@extends('admin.layout')

@section('content')

<div class="space-y-6">

    <!-- PAGE HEADER -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <div>

            <h1 class="text-3xl font-bold text-gray-800">
                Products Management
            </h1>

            <p class="text-gray-500 mt-1">
                Manage your ecommerce products inventory
            </p>

        </div>

        <a href="{{ route('admin.products.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl shadow transition text-center">

            + Add Product

        </a>

    </div>

    <!-- SEARCH -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">

        <form method="GET"
              class="flex flex-col md:flex-row gap-4">

            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Search products..."
                   class="flex-1 border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">

            <button type="submit"
                    class="bg-gray-900 hover:bg-black text-white px-6 py-3 rounded-xl transition">

                Search

            </button>

        </form>

    </div>

    <!-- PRODUCTS TABLE -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        <!-- TABLE HEADER -->
        <div class="p-6 border-b border-gray-100">

            <h2 class="text-xl font-bold text-gray-800">
                All Products
            </h2>

        </div>

        @if($products->count())

            <!-- DESKTOP TABLE -->
            <div class="hidden lg:block overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-gray-50">

                        <tr class="text-left text-sm text-gray-600">

                            <th class="p-5 font-semibold">Product</th>
                            <th class="p-5 font-semibold">Category</th>
                            <th class="p-5 font-semibold">Price</th>
                            <th class="p-5 font-semibold">Stock</th>
                            <th class="p-5 font-semibold">Status</th>
                            <th class="p-5 font-semibold text-right">Actions</th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @foreach($products as $product)

                            <tr class="hover:bg-gray-50 transition">

                                <!-- PRODUCT -->
                                <td class="p-5">

                                    <div class="flex items-center gap-4">

                                        @if($product->image)

                                            <img src="{{ asset('uploads/products/' . $product->image) }}"
                                                 class="w-16 h-16 rounded-xl object-cover border">

                                        @else

                                            <div class="w-16 h-16 rounded-xl bg-gray-200 flex items-center justify-center">
                                                📦
                                            </div>

                                        @endif

                                        <div>

                                            <h3 class="font-semibold text-gray-800">
                                                {{ $product->name }}
                                            </h3>

                                            <p class="text-sm text-gray-500 mt-1">
                                                ID: #{{ $product->id }}
                                            </p>

                                        </div>

                                    </div>

                                </td>

                                <!-- CATEGORY -->
                                <td class="p-5 text-gray-700">

                                    {{ $product->category->name ?? 'N/A' }}

                                </td>

                                <!-- PRICE -->
                                <td class="p-5">

                                    @if($product->sale_price)

                                        <div class="space-y-1">

                                            <p class="font-bold text-red-600">
                                                KSh {{ number_format($product->sale_price, 2) }}
                                            </p>

                                            <p class="text-sm text-gray-400 line-through">
                                                KSh {{ number_format($product->price, 2) }}
                                            </p>

                                        </div>

                                    @else

                                        <p class="font-bold text-gray-800">
                                            KSh {{ number_format($product->price, 2) }}
                                        </p>

                                    @endif

                                </td>

                                <!-- STOCK -->
                                <td class="p-5">

                                    @if($product->stock_quantity < 5)

                                        <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs font-bold">
                                            Low Stock
                                        </span>

                                    @else

                                        <span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-xs font-bold">
                                            {{ $product->stock_quantity }} In Stock
                                        </span>

                                    @endif

                                </td>

                                <!-- STATUS -->
                                <td class="p-5">

                                    <div class="flex flex-wrap gap-2">

                                        @if($product->is_flash_sale)

                                            <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs font-bold">
                                                Flash Sale
                                            </span>

                                        @endif

                                        @if($product->sale_price)

                                            <span class="bg-blue-100 text-blue-600 px-3 py-1 rounded-full text-xs font-bold">
                                                Discounted
                                            </span>

                                        @endif

                                    </div>

                                </td>

                                <!-- ACTIONS -->
                                <td class="p-5">

                                    <div class="flex items-center justify-end gap-3">

                                        <a href="{{ route('admin.products.edit', $product->id) }}"
                                           class="bg-blue-100 hover:bg-blue-200 text-blue-700 px-4 py-2 rounded-lg text-sm font-medium transition">

                                            Edit

                                        </a>

                                        <form method="POST"
                                              action="{{ route('admin.products.destroy', $product->id) }}"
                                              onsubmit="return confirm('Delete this product?')">

                                            @csrf
                                            @method('DELETE')

                                            <button class="bg-red-100 hover:bg-red-200 text-red-600 px-4 py-2 rounded-lg text-sm font-medium transition">

                                                Delete

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            <!-- MOBILE CARDS -->
            <div class="lg:hidden divide-y divide-gray-100">

                @foreach($products as $product)

                    <div class="p-5 space-y-4">

                        <div class="flex gap-4">

                            @if($product->image)

                                <img src="{{ asset('uploads/products/' . $product->image) }}"
                                     class="w-24 h-24 rounded-xl object-cover border">

                            @else

                                <div class="w-24 h-24 rounded-xl bg-gray-200 flex items-center justify-center">
                                    📦
                                </div>

                            @endif

                            <div class="flex-1">

                                <h3 class="font-bold text-gray-800">
                                    {{ $product->name }}
                                </h3>

                                <p class="text-sm text-gray-500 mt-1">
                                    {{ $product->category->name ?? 'N/A' }}
                                </p>

                                <div class="mt-3">

                                    @if($product->sale_price)

                                        <p class="font-bold text-red-600">
                                            KSh {{ number_format($product->sale_price, 2) }}
                                        </p>

                                        <p class="text-sm text-gray-400 line-through">
                                            KSh {{ number_format($product->price, 2) }}
                                        </p>

                                    @else

                                        <p class="font-bold text-gray-800">
                                            KSh {{ number_format($product->price, 2) }}
                                        </p>

                                    @endif

                                </div>

                            </div>

                        </div>

                        <!-- BADGES -->
                        <div class="flex flex-wrap gap-2">

                            @if($product->is_flash_sale)

                                <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs font-bold">
                                    Flash Sale
                                </span>

                            @endif

                            @if($product->stock_quantity < 5)

                                <span class="bg-orange-100 text-orange-600 px-3 py-1 rounded-full text-xs font-bold">
                                    Low Stock
                                </span>

                            @else

                                <span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-xs font-bold">
                                    {{ $product->stock_quantity }} In Stock
                                </span>

                            @endif

                        </div>

                        <!-- ACTIONS -->
                        <div class="flex gap-3">

                            <a href="{{ route('admin.products.edit', $product->id) }}"
                               class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center py-3 rounded-xl font-medium transition">

                                Edit

                            </a>

                            <form method="POST"
                                  action="{{ route('admin.products.destroy', $product->id) }}"
                                  class="flex-1"
                                  onsubmit="return confirm('Delete this product?')">

                                @csrf
                                @method('DELETE')

                                <button class="w-full bg-red-500 hover:bg-red-600 text-white py-3 rounded-xl font-medium transition">

                                    Delete

                                </button>

                            </form>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <!-- EMPTY STATE -->
            <div class="p-16 text-center">

                <div class="text-6xl mb-5">
                    📦
                </div>

                <h3 class="text-2xl font-bold text-gray-700">
                    No Products Found
                </h3>

                <p class="text-gray-500 mt-2">
                    Start by adding your first product
                </p>

                <a href="{{ route('admin.products.create') }}"
                   class="inline-block mt-6 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl transition">

                    Add Product

                </a>

            </div>

        @endif

    </div>

</div>

@endsection
