@extends('admin.layout')

@section('content')

<div class="min-h-screen flex items-center justify-center px-4 py-10">

    <div class="w-full max-w-5xl">

        <!-- CARD -->
        <div class="bg-white shadow-2xl rounded-3xl overflow-hidden border border-gray-100">

            <!-- HEADER -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-6 sm:px-10 py-8">

                <h1 class="text-3xl sm:text-4xl font-bold text-white">
                    Create Product
                </h1>

                <p class="text-blue-100 mt-2 text-sm sm:text-base">
                    Add a new product to your ecommerce inventory
                </p>

            </div>

            <!-- FORM -->
            <form method="POST"
                  action="{{ route('admin.products.store') }}"
                  enctype="multipart/form-data"
                  class="p-6 sm:p-10 space-y-8">

                @csrf

                <!-- BASIC INFO -->
                <div class="bg-gray-50 border border-gray-200 rounded-2xl p-6 sm:p-8">

                    <div class="mb-6">

                        <h2 class="text-xl font-bold text-gray-800">
                            Basic Information
                        </h2>

                        <p class="text-sm text-gray-500 mt-1">
                            Enter the main product details
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
                                   placeholder="e.g iPhone 15 Pro Max"
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

                                    <option value="{{ $cat->id }}">
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
                                   placeholder="0.00"
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
                                   placeholder="Discount price"
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
                               class="w-6 h-6 accent-red-500">

                    </div>

                    <!-- SALE END -->
                    <div class="mt-6">

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Sale Ends At
                        </label>

                        <input type="datetime-local"
                               name="sale_ends_at"
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
                               placeholder="0"
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
                            Add detailed information about the product
                        </p>

                    </div>

                    <textarea name="description"
                              rows="6"
                              placeholder="Write product details..."
                              class="w-full border border-gray-300 rounded-xl px-4 py-4
                                     focus:ring-2 focus:ring-blue-500
                                     focus:border-blue-500
                                     outline-none transition resize-none"></textarea>

                </div>

                <!-- IMAGE -->
                <div class="bg-gray-50 border border-gray-200 rounded-2xl p-6 sm:p-8">

                    <div class="mb-6">

                        <h2 class="text-xl font-bold text-gray-800">
                            Product Image
                        </h2>

                        <p class="text-sm text-gray-500 mt-1">
                            Upload a product image
                        </p>

                    </div>

                    <input type="file"
                           name="image"
                           class="w-full border border-gray-300 rounded-xl px-4 py-3 bg-white">

                </div>

                <!-- ACTIONS -->
                <div class="flex flex-col sm:flex-row gap-4">

                    <!-- SAVE -->
                    <button type="submit"
                            class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-700
                                   hover:from-blue-700 hover:to-indigo-800
                                   text-white font-bold py-4 rounded-2xl
                                   transition duration-200 shadow-lg hover:shadow-xl">

                        Save Product

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
