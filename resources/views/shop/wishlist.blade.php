@extends('shop.layout')

@section('content')

<div class="max-w-7xl mx-auto px-4 py-8">

    <div class="flex items-center justify-between mb-8">

        <h1 class="text-3xl font-bold text-gray-800">
            My Wishlist
        </h1>

        <a href="{{ route('shop') }}"
           class="text-blue-600 hover:underline">
            ← Continue Shopping
        </a>

    </div>

    @if($wishlistItems->count())

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

        @foreach($wishlistItems as $item)

            <div class="bg-white rounded-xl shadow overflow-hidden">

                <a href="{{ route('product.show', $item->product->slug) }}">

                    @if($item->product->image)

                        <img src="{{ asset('storage/' . $item->product->image) }}"
                             class="w-full h-56 object-cover">

                    @endif

                </a>

                <div class="p-4">

                    <h2 class="font-semibold text-gray-800 mb-2">
                        {{ $item->product->name }}
                    </h2>

                    <p class="text-blue-600 font-bold mb-4">
                        KSh {{ number_format($item->product->price, 2) }}
                    </p>

                    <div class="space-y-3">

                        <form action="{{ route('cart.add', $item->product->id) }}"
                              method="POST">

                            @csrf

                            <button type="submit"
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg">

                                Add To Cart
                            </button>

                        </form>

                        <form action="{{ route('wishlist.destroy', $item->id) }}"
                              method="POST">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="w-full border border-red-500 text-red-500 hover:bg-red-500 hover:text-white py-2 rounded-lg">

                                Remove
                            </button>

                        </form>

                    </div>

                </div>

            </div>

        @endforeach

    </div>

    @else

    <div class="bg-white rounded-xl shadow p-10 text-center">

        <div class="text-6xl mb-4">
            ❤️
        </div>

        <h2 class="text-2xl font-bold text-gray-800 mb-2">
            Your wishlist is empty
        </h2>

        <p class="text-gray-500 mb-6">
            Save products you love for later.
        </p>

        <a href="{{ route('shop') }}"
           class="bg-blue-600 text-white px-6 py-3 rounded-lg">
            Browse Products
        </a>

    </div>

    @endif

</div>

@endsection
