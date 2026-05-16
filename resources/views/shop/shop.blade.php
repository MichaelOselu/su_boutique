@extends('shop.layout')

@section('content')

<div class="max-w-7xl mx-auto px-4 py-6">

    <!-- PAGE HEADER -->
    <div class="mb-6">

        <h1 class="text-3xl font-bold text-gray-800">
            Shop Products
        </h1>

        <p class="text-gray-500 mt-1">
            Browse products, filter categories, and discover deals.
        </p>

    </div>

    {{-- =========================
         FLASH SALES SECTION (STEP 12)
    ========================= --}}
    @if(isset($flashSales) && $flashSales->count())

    <section class="mb-10">

        <div class="flex items-center justify-between mb-6">

            <div>
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">
                    ⚡ Flash Sales
                </h2>

                <p class="text-gray-500 text-sm mt-1">
                    Limited time offers available now
                </p>
            </div>

        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

            @foreach($flashSales as $product)

                <div class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden relative">

                    <!-- DISCOUNT BADGE -->
                    @if($product->hasDiscount())
                        <div class="absolute top-3 left-3 z-10">
                            <span class="bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full">
                                -{{ $product->discountPercentage() }}%
                            </span>
                        </div>
                    @endif

                    <a href="{{ route('product.show', $product->slug) }}">

                        <img src="{{ asset('storage/' . $product->image) }}"
                             class="w-full h-52 object-cover">

                    </a>

                    <div class="p-4">

                        <h3 class="font-semibold text-gray-800 line-clamp-2">
                            {{ $product->name }}
                        </h3>

                        <div class="mt-3 flex items-center gap-3 flex-wrap">

                            <span class="text-red-600 font-bold">
                                KSh {{ number_format($product->sale_price, 2) }}
                            </span>

                            <span class="text-gray-400 line-through text-sm">
                                KSh {{ number_format($product->price, 2) }}
                            </span>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    </section>

    @endif


    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

        <!-- SIDEBAR FILTERS -->
        <div class="lg:col-span-1">

            <div class="bg-white rounded-lg shadow p-5 sticky top-4">

                <h2 class="text-lg font-semibold mb-4">
                    Filters
                </h2>

                <form method="GET" action="{{ route('shop') }}" class="space-y-5">

                    <!-- SEARCH -->
                    <div>
                        <label class="block text-sm font-medium mb-2">
                            Search
                        </label>

                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               class="w-full border rounded-lg p-2">
                    </div>

                    <!-- CATEGORY -->
                    <div>
                        <label class="block text-sm font-medium mb-2">
                            Category
                        </label>

                        <select name="category" class="w-full border rounded-lg p-2">

                            <option value="">All Categories</option>

                            @foreach($categories as $category)

                                <option value="{{ $category->id }}"
                                    {{ request('category') == $category->id ? 'selected' : '' }}>

                                    {{ $category->name }}

                                </option>

                            @endforeach

                        </select>
                    </div>

                    <!-- MIN PRICE -->
                    <div>
                        <label class="block text-sm font-medium mb-2">
                            Min Price
                        </label>

                        <input type="number"
                               name="min_price"
                               value="{{ request('min_price') }}"
                               class="w-full border rounded-lg p-2">
                    </div>

                    <!-- MAX PRICE -->
                    <div>
                        <label class="block text-sm font-medium mb-2">
                            Max Price
                        </label>

                        <input type="number"
                               name="max_price"
                               value="{{ request('max_price') }}"
                               class="w-full border rounded-lg p-2">
                    </div>

                    <!-- SORT -->
                    <div>
                        <label class="block text-sm font-medium mb-2">
                            Sort By
                        </label>

                        <select name="sort" class="w-full border rounded-lg p-2">

                            <option value="latest">Latest</option>
                            <option value="price_low">Price: Low to High</option>
                            <option value="price_high">Price: High to Low</option>

                        </select>
                    </div>

                    <div class="flex gap-2">

                        <button type="submit"
                                class="bg-blue-600 text-white px-4 py-2 rounded-lg w-full hover:bg-blue-700">

                            Apply
                        </button>

                        <a href="{{ route('shop') }}"
                           class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-center w-full">

                            Reset
                        </a>

                    </div>

                </form>

            </div>

        </div>

        <!-- PRODUCTS -->
        <div class="lg:col-span-3">

            <div class="flex justify-between items-center mb-4">

                <p class="text-gray-600">
                    Showing {{ $products->total() }} products
                </p>

            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">

                @forelse($products as $product)

                    {{-- FIX: relative added here --}}
                    <div class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden relative">

                        @if($product->hasDiscount())

                            <div class="absolute top-3 left-3 z-10">

                                <span class="bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow">

                                    -{{ $product->discountPercentage() }}%

                                </span>

                            </div>

                        @endif

                        <a href="{{ route('product.show', $product->slug) }}">

                            @if($product->image)

                                <img src="{{ asset('storage/' . $product->image) }}"
                                     class="w-full h-56 object-cover">

                            @else

                                <div class="w-full h-56 bg-gray-200 flex items-center justify-center">
                                    No Image
                                </div>

                            @endif

                        </a>

                        <div class="p-4">

                            <h3 class="font-semibold text-lg text-gray-800 mb-2 line-clamp-1">
                                {{ $product->name }}
                            </h3>

                            <p class="text-gray-500 text-sm mb-3 line-clamp-2">
                                {{ $product->description }}
                            </p>

                            <div class="flex items-center justify-between">

                                <span class="text-xl font-bold text-blue-600">
                                    KSh {{ number_format($product->price, 2) }}
                                </span>

                                <a href="{{ route('product.show', $product->slug) }}"
                                   class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">

                                    View
                                </a>

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="col-span-full bg-white rounded-lg shadow p-10 text-center">

                        <p class="text-gray-500 text-lg">
                            No products found.
                        </p>

                    </div>

                @endforelse

            </div>

            <div class="mt-8">
                {{ $products->links() }}
            </div>

        </div>

    </div>

</div>

@endsection
