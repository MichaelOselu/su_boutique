@extends('shop.layout')

@section('content')

<div class="max-w-7xl mx-auto">

    <!-- HEADER -->
    <div class="mb-6">

        <h1 class="text-2xl font-bold">
            Search Results
        </h1>

        <p class="text-gray-500 mt-1">
            Showing results for:
            <span class="font-semibold">"{{ $query }}"</span>
        </p>

    </div>

    <!-- EMPTY STATE -->
    @if($products->count() == 0)

        <div class="bg-white rounded shadow p-10 text-center">

            <h2 class="text-xl font-semibold text-gray-700 mb-2">
                No products found
            </h2>

            <p class="text-gray-500">
                Try another keyword.
            </p>

        </div>

    @else

        <!-- PRODUCTS GRID -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

            @foreach($products as $product)

                <div class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden">

                    <!-- IMAGE -->
                    <img
                        src="{{ asset('storage/' . $product->image) }}"
                        class="w-full h-52 object-cover">

                    <!-- CONTENT -->
                    <div class="p-4">

                        <h2 class="font-semibold text-lg text-gray-800">
                            {{ $product->name }}
                        </h2>

                        <p class="text-blue-600 font-bold mt-2">
                            KSh {{ $product->price }}
                        </p>

                        <a href="{{ route('product.show', $product->slug) }}"
                           class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">

                            View Product
                        </a>

                    </div>

                </div>

            @endforeach

        </div>

        <!-- PAGINATION -->
        <div class="mt-8">
            {{ $products->withQueryString()->links() }}
        </div>

    @endif

</div>

@endsection
