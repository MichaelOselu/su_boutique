@extends('shop.layout')

@section('title', $product->name)

@section('content')

<div class="max-w-7xl mx-auto py-6 sm:py-8">

    <!-- BREADCRUMB -->
    <div class="flex flex-wrap items-center gap-2 text-sm text-gray-500 mb-6">

        <a href="{{ route('home') }}"
           class="hover:text-blue-600">
            Home
        </a>

        <span>/</span>

        <a href="{{ route('shop') }}"
           class="hover:text-blue-600">
            Shop
        </a>

        <span>/</span>

        <span class="text-gray-700 font-medium">
            {{ $product->name }}
        </span>

    </div>

    <!-- PRODUCT SECTION -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">



                            @if($product->hasDiscount())

                        <div class="absolute top-3 left-3 z-10">

                            <span class="bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow">

                                -{{ $product->discountPercentage() }}%

                            </span>

                        </div>

                    @endif


        <!-- =========================
             PRODUCT IMAGES
        ========================= -->
        <div class="space-y-4">

            <!-- MAIN IMAGE -->
            <div class="bg-white rounded-2xl shadow overflow-hidden">

                @if($product->image)

                    <img src="{{ asset('storage/' . $product->image) }}"
                         alt="{{ $product->name }}"
                         class="w-full h-[320px] sm:h-[450px] object-cover">

                @else

                    <div class="w-full h-[320px] sm:h-[450px] bg-gray-200 flex items-center justify-center text-gray-500">
                        No Image
                    </div>

                @endif

            </div>

            <!-- IMAGE GALLERY -->
            <div class="grid grid-cols-4 gap-3">

                @for($i = 0; $i < 4; $i++)

                    <div class="bg-white border rounded-xl overflow-hidden shadow-sm">

                        @if($product->image)

                            <img src="{{ asset('storage/' . $product->image) }}"
                                 class="w-full h-20 sm:h-24 object-cover hover:scale-105 transition duration-300">

                        @endif

                    </div>

                @endfor

            </div>

        </div>

        <!-- =========================
             PRODUCT INFO
        ========================= -->
        <div>

            <!-- CATEGORY -->
            <span class="inline-flex items-center bg-blue-100 text-blue-700 text-xs sm:text-sm px-4 py-1 rounded-full mb-4">

                {{ $product->category->name ?? 'General' }}

            </span>

            <!-- PRODUCT NAME -->
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-800 leading-tight mb-4">

                {{ $product->name }}

            </h1>

            <!-- RATING -->
            <div class="flex flex-wrap items-center gap-3 mb-6">

                <div class="text-yellow-500 text-xl">

                    @for($i = 1; $i <= 5; $i++)

                        @if($i <= round($averageRating))
                            ★
                        @else
                            ☆
                        @endif

                    @endfor

                </div>

                <span class="text-gray-600 text-sm">
                    {{ $averageRating ?: '0.0' }}
                    •
                    {{ $product->reviews->count() }} Reviews
                </span>

            </div>

            <!-- PRICE -->
            <div class="mb-6">

                @if($product->hasDiscount())

                    <div class="flex items-center gap-4 flex-wrap">

                        <span class="text-4xl font-bold text-red-600">
                            KSh {{ number_format($product->sale_price, 2) }}
                        </span>

                        <span class="text-xl text-gray-400 line-through">
                            KSh {{ number_format($product->price, 2) }}
                        </span>

                        <span class="bg-red-100 text-red-600 text-sm font-semibold px-3 py-1 rounded-full">
                            -{{ $product->discountPercentage() }}%
                        </span>

                    </div>

                @else

                    <span class="text-4xl font-bold text-blue-600">
                        KSh {{ number_format($product->price, 2) }}
                    </span>

                @endif

            </div>

            <!-- DESCRIPTION -->
            <div class="mb-8">

                <h3 class="font-bold text-lg text-gray-800 mb-3">
                    Description
                </h3>

                <p class="text-gray-600 leading-relaxed">
                    {{ $product->description }}
                </p>

            </div>

            <!-- QUANTITY -->
            <div class="mb-8">

                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    Quantity
                </label>

                <div class="flex items-center gap-3">

                    <button type="button"
                            id="minus-btn"
                            class="w-10 h-10 rounded-lg bg-gray-200 hover:bg-gray-300 text-lg">
                        -
                    </button>

                    <input type="number"
                           value="1"
                           min="1"
                           id="qty"
                           class="w-20 border rounded-lg p-2 text-center font-semibold">

                    <button type="button"
                            id="plus-btn"
                            class="w-10 h-10 rounded-lg bg-gray-200 hover:bg-gray-300 text-lg">
                        +
                    </button>

                </div>

            </div>

            <!-- ACTION BUTTONS -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">

                <!-- ADD TO CART -->
                <form action="{{ route('cart.add', $product->id) }}"
                      method="POST"
                      class="sm:col-span-1">

                    @csrf

                    <input type="hidden"
                           name="quantity"
                           id="cartQty"
                           value="1">

                    <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-semibold transition shadow">

                        Add To Cart
                    </button>

                </form>

                <!-- WISHLIST -->
                @auth

                <form action="{{ route('wishlist.store', $product->id) }}"
                      method="POST"
                      class="sm:col-span-1">

                    @csrf

                    <button type="submit"
                            class="w-full border border-red-500 text-red-500 hover:bg-red-500 hover:text-white py-3 rounded-xl font-semibold transition">

                        ❤️ Wishlist
                    </button>

                </form>

                @endauth

                <!-- BUY NOW -->
                <a href="{{ route('checkout.index') }}"
                   class="sm:col-span-1 bg-green-600 hover:bg-green-700 text-white py-3 rounded-xl font-semibold text-center transition shadow">

                    Buy Now
                </a>

            </div>

            <!-- FEATURES -->
            <div class="grid grid-cols-2 gap-4">

                <div class="bg-white border rounded-2xl p-5 text-center shadow-sm">

                    <div class="text-3xl mb-3">
                        🚚
                    </div>

                    <p class="font-semibold text-gray-800">
                        Fast Delivery
                    </p>

                    <p class="text-xs text-gray-500 mt-1">
                        Nationwide shipping
                    </p>

                </div>

                <div class="bg-white border rounded-2xl p-5 text-center shadow-sm">

                    <div class="text-3xl mb-3">
                        🔒
                    </div>

                    <p class="font-semibold text-gray-800">
                        Secure Payment
                    </p>

                    <p class="text-xs text-gray-500 mt-1">
                        Protected checkout
                    </p>

                </div>

            </div>

        </div>

    </div>

    <!-- =========================
         CUSTOMER REVIEWS
    ========================= -->
    <div class="mt-16 bg-white rounded-2xl shadow p-5 sm:p-8">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-10">

            <div>

                <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">
                    Customer Reviews
                </h2>

                <p class="text-gray-500 mt-2">
                    Reviews from verified customers
                </p>

            </div>

            <div class="text-center lg:text-right">

                <div class="text-5xl font-extrabold text-yellow-500">
                    {{ $averageRating ?: '0.0' }}
                </div>

                <div class="text-yellow-500 text-xl mt-2">
                    ★★★★★
                </div>

                <div class="text-gray-500 text-sm mt-1">
                    {{ $product->reviews->count() }} total reviews
                </div>

            </div>

        </div>

        <!-- REVIEW FORM -->
        @auth

        <div class="bg-gray-50 border rounded-2xl p-5 sm:p-6 mb-10">

            <h3 class="text-xl font-bold text-gray-800 mb-5">
                Leave a Review
            </h3>

            @if(session('success'))

                <div class="bg-green-100 text-green-700 px-4 py-3 rounded-lg mb-5">
                    {{ session('success') }}
                </div>

            @endif

            <form action="{{ route('reviews.store', $product->id) }}"
                  method="POST"
                  class="space-y-5">

                @csrf

                <!-- RATING -->
                <div>

                    <label class="block text-sm font-semibold mb-2">
                        Rating
                    </label>

                    <select name="rating"
                            class="w-full border rounded-xl p-3">

                        <option value="">Select Rating</option>

                        <option value="5">★★★★★ - Excellent</option>
                        <option value="4">★★★★☆ - Very Good</option>
                        <option value="3">★★★☆☆ - Good</option>
                        <option value="2">★★☆☆☆ - Fair</option>
                        <option value="1">★☆☆☆☆ - Poor</option>

                    </select>

                </div>

                <!-- COMMENT -->
                <div>

                    <label class="block text-sm font-semibold mb-2">
                        Review
                    </label>

                    <textarea name="comment"
                              rows="5"
                              class="w-full border rounded-xl p-4"
                              placeholder="Share your experience with this product..."></textarea>

                </div>

                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-semibold transition">

                    Submit Review
                </button>

            </form>

        </div>

        @else

        <div class="bg-blue-50 border border-blue-100 rounded-xl p-5 mb-10">

            <p class="text-gray-700 text-sm sm:text-base">

                Please

                <a href="{{ route('login') }}"
                   class="text-blue-600 font-semibold hover:underline">

                    login

                </a>

                to leave a review.

            </p>

        </div>

        @endauth

        <!-- REVIEWS -->
        <div class="space-y-6">

            @forelse($product->reviews as $review)

                <div class="border rounded-2xl p-5 hover:shadow-md transition">

                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-4">

                        <div>

                            <div class="flex flex-wrap items-center gap-2">

                                <h4 class="font-bold text-gray-800">
                                    {{ $review->user->name }}
                                </h4>

                                @if($review->verified_purchase)

                                    <span class="bg-green-100 text-green-700 text-xs px-3 py-1 rounded-full">
                                        Verified Buyer
                                    </span>

                                @endif

                            </div>

                            <p class="text-sm text-gray-400 mt-1">
                                {{ $review->created_at->diffForHumans() }}
                            </p>

                        </div>

                        <div class="text-yellow-500 text-lg">

                            @for($i = 1; $i <= 5; $i++)

                                @if($i <= $review->rating)
                                    ★
                                @else
                                    ☆
                                @endif

                            @endfor

                        </div>

                    </div>

                    <p class="text-gray-600 leading-relaxed">
                        {{ $review->comment }}
                    </p>

                </div>

            @empty

                <div class="text-center py-12 text-gray-500">

                    <div class="text-5xl mb-4">
                        ⭐
                    </div>

                    <p class="text-lg font-medium">
                        No reviews yet
                    </p>

                    <p class="text-sm mt-2">
                        Be the first customer to review this product.
                    </p>

                </div>

            @endforelse

        </div>

    </div>

    <!-- =========================
         RELATED PRODUCTS
    ========================= -->
    @if(isset($relatedProducts) && $relatedProducts->count())

    <div class="mt-16">

        <div class="flex items-center justify-between mb-8">

            <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">
                Related Products
            </h2>

        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            @foreach($relatedProducts as $related)

                <div class="bg-white rounded-2xl shadow hover:shadow-xl transition overflow-hidden group">

                    <a href="{{ route('product.show', $related->slug) }}">

                        @if($related->image)

                            <div class="overflow-hidden">

                                <img src="{{ asset('storage/' . $related->image) }}"
                                     class="w-full h-56 object-cover group-hover:scale-105 transition duration-300">

                            </div>

                        @endif

                    </a>

                    <div class="p-5">

                        <h3 class="font-semibold text-gray-800 mb-3 line-clamp-2">
                            {{ $related->name }}
                        </h3>

                        <div class="flex items-center justify-between">

                            <span class="text-blue-600 font-bold text-lg">
                                KSh {{ number_format($related->price, 2) }}
                            </span>

                            <a href="{{ route('product.show', $related->slug) }}"
                               class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-lg transition">

                                View
                            </a>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    </div>

    @endif

    <!-- =========================
         YOU MAY ALSO LIKE
    ========================= -->
    @if(isset($recommendedProducts) && $recommendedProducts->count())

    <div class="mt-16">

        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-8">
            You May Also Like
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            @foreach($recommendedProducts as $item)

                <div class="bg-white rounded-2xl shadow hover:shadow-xl transition overflow-hidden group">

                    <a href="{{ route('product.show', $item->slug) }}">

                        @if($item->image)

                            <div class="overflow-hidden">

                                <img src="{{ asset('storage/' . $item->image) }}"
                                     class="w-full h-56 object-cover group-hover:scale-105 transition duration-300">

                            </div>

                        @endif

                    </a>

                    <div class="p-5">

                        <h3 class="font-semibold text-gray-800 mb-3 line-clamp-2">
                            {{ $item->name }}
                        </h3>

                        <div class="flex items-center justify-between">

                            <span class="text-blue-600 font-bold text-lg">
                                KSh {{ number_format($item->price, 2) }}
                            </span>

                            <a href="{{ route('product.show', $item->slug) }}"
                               class="bg-gray-800 hover:bg-black text-white text-sm px-4 py-2 rounded-lg transition">

                                View
                            </a>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    </div>

    @endif


    <!-- RECENTLY VIEWED -->
@if(isset($recentProducts) && $recentProducts->count())

<div class="mt-16">

    <div class="flex items-center justify-between mb-6">

        <h2 class="text-2xl font-bold text-gray-800">
            Recently Viewed
        </h2>

        <a href="{{ route('shop') }}"
           class="text-blue-600 hover:underline text-sm">
            View More
        </a>

    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

        @foreach($recentProducts as $item)

            <div class="bg-white rounded-2xl shadow hover:shadow-xl transition overflow-hidden">

                <a href="{{ route('product.show', $item->slug) }}">

                    @if($item->image)

                        <img src="{{ asset('storage/' . $item->image) }}"
                             class="w-full h-52 object-cover">

                    @else

                        <div class="w-full h-52 bg-gray-200"></div>

                    @endif

                </a>

                <div class="p-4">

                    <h3 class="font-semibold text-gray-800 line-clamp-2 min-h-[48px]">
                        {{ $item->name }}
                    </h3>

                    <div class="flex items-center justify-between mt-4">

                        <span class="text-blue-600 font-bold">
                            KSh {{ number_format($item->price, 2) }}
                        </span>

                        <a href="{{ route('product.show', $item->slug) }}"
                           class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-lg transition">

                            View
                        </a>

                    </div>

                </div>

            </div>

        @endforeach

    </div>

</div>

@endif


</div>

<!-- =========================
     QUANTITY SCRIPT
========================= -->
<script>

    const qtyInput = document.getElementById('qty');
    const cartQty = document.getElementById('cartQty');

    document.getElementById('plus-btn').addEventListener('click', () => {
        qtyInput.value = parseInt(qtyInput.value) + 1;
        cartQty.value = qtyInput.value;
    });

    document.getElementById('minus-btn').addEventListener('click', () => {

        if (parseInt(qtyInput.value) > 1) {
            qtyInput.value = parseInt(qtyInput.value) - 1;
            cartQty.value = qtyInput.value;
        }

    });

    qtyInput.addEventListener('change', function() {

        if (this.value < 1) {
            this.value = 1;
        }

        cartQty.value = this.value;
    });

</script>



@endsection
