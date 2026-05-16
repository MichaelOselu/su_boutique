@extends('admin.layout')

@section('content')

<div class="min-h-screen flex items-center justify-center px-4 py-10">

    <div class="w-full max-w-5xl">

        <!-- CARD -->
        <div class="bg-white shadow-2xl rounded-3xl overflow-hidden border border-gray-100">

            <!-- HEADER -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-6 sm:px-10 py-8">

                <h1 class="text-3xl sm:text-4xl font-bold text-white">
                    Edit Product
                </h1>

                <p class="text-blue-100 mt-2 text-sm sm:text-base">
                    Update product information and pricing
                </p>

            </div>

            <!-- FORM -->
            <form method="POST"
                  action="{{ route('admin.products.update', $product->id) }}"
                  enctype="multipart/form-data"
                  class="p-6 sm:p-10 space-y-8">

                @csrf
                @method('PUT')

                <!-- BASIC INFO -->
                <div class="bg-gray-50 border border-gray-200 rounded-2xl p-6 sm:p-8">

                    <div class="mb-6">

                        <h2 class="text-xl font-bold text-gray-800">
                            Basic Information
                        </h2>

                        <p class="text-sm text-gray-500 mt-1">
                            Update the main product details
                        </p>

                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- PRODUCT NAME -->
                        <div class="md:col-span-2">

                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Product Name
                            </label>

                            <input type="text"
                                   name="name"
                                   value="{{ $product->name }}"
                                   class="w-full border border-gray-300 rounded-xl px-4 py-4
                                          focus:ring-2 focus:ring-blue-500
                                          focus:border-blue-500
                                          outline-none transition">

                        </div>

                        <!-- CATEGORY -->
                        <div class="md:col-span-2">

                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Category
                            </label>

                            <select name="category_id"
                                    class="w-full border border-gray-300 rounded-xl px-4 py-4
                                           focus:ring-2 focus:ring-blue-500
                                           focus:border-blue-500
                                           outline-none transition">

                                @foreach($categories as $cat)

                                    <option value="{{ $cat->id }}"
                                        {{ $product->category_id == $cat->id ? 'selected' : '' }}>

                                        {{ $cat->name }}

                                    </option>

                                @endforeach

                            </select>

                        </div>

                    </div>

                </div>

                <!-- PRICING -->
                <div class="bg-blue-50 border border-blue-100 rounded-2xl p-6 sm:p-8">

                    <div class="mb-6">

                        <h2 class="text-xl font-bold text-blue-800">
                            Pricing & Discounts
                        </h2>

                        <p class="text-sm text-blue-600 mt-1">
                            Configure pricing and promotional offers
                        </p>

                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- PRICE -->
                        <div>

                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Price (KSh)
                            </label>

                            <input type="number"
                                   step="0.01"
                                   name="price"
                                   value="{{ $product->price }}"
                                   class="w-full border border-gray-300 rounded-xl px-4 py-4
                                          focus:ring-2 focus:ring-indigo-500
                                          focus:border-indigo-500
                                          outline-none transition">

                        </div>

                        <!-- SALE PRICE -->
                        <div>

                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Sale Price
                            </label>

                            <input type="number"
                                   step="0.01"
                                   name="sale_price"
                                   value="{{ $product->sale_price }}"
                                   class="w-full border border-gray-300 rounded-xl px-4 py-4
                                          focus:ring-2 focus:ring-indigo-500
                                          focus:border-indigo-500
                                          outline-none transition">

                        </div>

                    </div>

                    <!-- FLASH SALE -->
                    <div class="mt-6 bg-red-50 border border-red-200 rounded-2xl p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                        <div>

                            <h3 class="font-bold text-red-700 text-lg">
                                ⚡ Flash Sale Product
                            </h3>

                            <p class="text-sm text-gray-600 mt-1">
                                Enable this to highlight the product in flash sales
                            </p>

                        </div>

                        <input type="checkbox"
                               name="is_flash_sale"
                               value="1"
                               class="w-6 h-6 accent-red-500"
                               {{ $product->is_flash_sale ? 'checked' : '' }}>

                    </div>

                    <!-- SALE END -->
                    <div class="mt-6">

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Sale Ends At
                        </label>

                        <input type="datetime-local"
                               name="sale_ends_at"
                               value="{{ $product->sale_ends_at ? \Carbon\Carbon::parse($product->sale_ends_at)->format('Y-m-d\TH:i') : '' }}"
                               class="w-full border border-gray-300 rounded-xl px-4 py-4
                                      focus:ring-2 focus:ring-indigo-500
                                      focus:border-indigo-500
                                      outline-none transition">

                    </div>

                </div>

                <!-- INVENTORY -->
                <div class="bg-green-50 border border-green-100 rounded-2xl p-6 sm:p-8">

                    <div class="mb-6">

                        <h2 class="text-xl font-bold text-green-800">
                            Inventory
                        </h2>

                        <p class="text-sm text-green-600 mt-1">
                            Manage stock availability
                        </p>

                    </div>

                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Stock Quantity
                        </label>

                        <input type="number"
                               name="stock_quantity"
                               value="{{ $product->stock_quantity }}"
                               class="w-full border border-gray-300 rounded-xl px-4 py-4
                                      focus:ring-2 focus:ring-green-500
                                      focus:border-green-500
                                      outline-none transition">

                    </div>

                </div>

                <!-- DESCRIPTION -->
                <div class="bg-gray-50 border border-gray-200 rounded-2xl p-6 sm:p-8">

                    <div class="mb-6">

                        <h2 class="text-xl font-bold text-gray-800">
                            Product Description
                        </h2>

                        <p class="text-sm text-gray-500 mt-1">
                            Update detailed product information
                        </p>

                    </div>

                    <textarea name="description"
                              rows="6"
                              class="w-full border border-gray-300 rounded-xl px-4 py-4
                                     focus:ring-2 focus:ring-blue-500
                                     focus:border-blue-500
                                     outline-none transition resize-none">{{ $product->description }}</textarea>

                </div>

                <!-- IMAGE -->
                <div class="bg-gray-50 border border-gray-200 rounded-2xl p-6 sm:p-8">

                    <div class="mb-6">

                        <h2 class="text-xl font-bold text-gray-800">
                            Product Image
                        </h2>

                        <p class="text-sm text-gray-500 mt-1">
                            Upload a new product image if needed
                        </p>

                    </div>

                    @if($product->image)

                        <div class="mb-6">

                            <p class="text-sm font-semibold text-gray-700 mb-3">
                                Current Image
                            </p>

                            <img src="{{ asset('storage/' . $product->image) }}"
                                 class="w-40 h-40 object-cover rounded-2xl border shadow">

                        </div>

                    @endif

                    <input type="file"
                           name="image"
                           class="w-full border border-gray-300 rounded-xl px-4 py-3 bg-white">

                </div>

                <!-- ACTIONS -->
                <div class="flex flex-col sm:flex-row gap-4">

                    <!-- UPDATE -->
                    <button type="submit"
                            class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-700
                                   hover:from-blue-700 hover:to-indigo-800
                                   text-white font-bold py-4 rounded-2xl
                                   transition duration-200 shadow-lg hover:shadow-xl">

                        Update Product

                    </button>

                    <!-- CANCEL -->
                    <a href="{{ route('admin.products.index') }}"
                       class="flex-1 bg-gray-200 hover:bg-gray-300
                              text-gray-700 font-bold py-4 rounded-2xl
                              text-center transition duration-200">

                        Cancel

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection
