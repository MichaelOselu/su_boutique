@extends('shop.layout')

@section('content')

<div class="max-w-7xl mx-auto px-4 py-8">

    <!-- PAGE HEADER -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">

        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                My Wishlist
            </h1>

            <p class="text-gray-500 mt-1">
                Products you saved for later
            </p>
        </div>

        <a href="{{ route('shop') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg transition">

            Continue Shopping
        </a>

    </div>

    <!-- SUCCESS MESSAGE -->
    @if(session('success'))

        <div class="bg-green-100 text-green-700 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>

    @endif

    <!-- WISHLIST GRID -->
    @if($wishlists->count())

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            @foreach($wishlists as $wishlist)

                <div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden">

                    <!-- IMAGE -->
                    <a href="{{ route('product.show', $wishlist->product->slug) }}">

                        @if($wishlist->product->image)

                            <img src="{{ asset('storage/' . $wishlist->product->image) }}"
                                 class="w-full h-56 object-cover">

                        @endif

                    </a>

                    <!-- CONTENT -->
                    <div class="p-4">

                        <h3 class="font-semibold text-gray-800 mb-2">
                            {{ $wishlist->product->name }}
                        </h3>

                        <div class="text-blue-600 font-bold text-lg mb-4">
                            KSh {{ number_format($wishlist->product->price, 2) }}
                        </div>

                        <!-- ACTIONS -->
                        <div class="flex gap-2">

                            <a href="{{ route('product.show', $wishlist->product->slug) }}"
                               class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center py-2 rounded-lg transition">

                                View
                            </a>

                            <form action="{{ route('wishlist.destroy', $wishlist->id) }}"
                                  method="POST">

                                @csrf
                                @method('DELETE')

                                <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition">

                                    ✕
                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    @else

        <!-- EMPTY STATE -->
        <div class="bg-white rounded-xl shadow p-10 text-center">

            <div class="text-6xl mb-4">
                ❤️
            </div>

            <h2 class="text-2xl font-bold text-gray-800 mb-2">
                Your wishlist is empty
            </h2>

            <p class="text-gray-500 mb-6">
                Save products you love and come back later.
            </p>

            <a href="{{ route('shop') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition">

                Start Shopping
            </a>

        </div>

    @endif

</div>

@endsection
