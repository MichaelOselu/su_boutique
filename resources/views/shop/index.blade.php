@extends('shop.layout')

@section('content')

<h1 class="text-2xl font-bold mb-4">Featured Products</h1>

<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">

@foreach($products as $product)

    <div class="bg-white p-3 rounded shadow">

        @if($product->image)

            <img src="{{ asset('storage/' . $product->image) }}"
                 class="w-full h-40 sm:h-48 object-contain bg-white">

        @else

            <div class="w-full h-40 sm:h-48 bg-gray-200 flex items-center justify-center text-sm text-gray-500">
                No Image
            </div>

        @endif

        <h2 class="font-bold mt-2 text-sm sm:text-base line-clamp-2">
            {{ $product->name }}
        </h2>

        <p class="text-sm text-gray-700">
            KSh {{ number_format($product->price, 2) }}
        </p>

        <a href="{{ route('product.show', $product->slug) }}"
           class="text-blue-500 text-sm mt-1 inline-block">

           View

        </a>

    </div>

@endforeach

</div>

@endsection
