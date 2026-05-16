@extends('admin.layout')

@section('content')

<div class="min-h-screen flex items-center justify-center px-4 py-10">

    <div class="w-full max-w-2xl">

        <!-- CARD -->
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden">

            <!-- HEADER -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-6 py-5">

                <h1 class="text-2xl sm:text-3xl font-bold text-white">
                    Create Category
                </h1>

                <p class="text-blue-100 text-sm mt-1">
                    Add a new product category to your ecommerce store
                </p>

            </div>

            <!-- FORM -->
            <form method="POST"
                  action="{{ route('admin.categories.store') }}"
                  class="p-6 sm:p-8 space-y-6">

                @csrf

                <!-- CATEGORY NAME -->
                <div>

                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Category Name
                    </label>

                    <input
                        type="text"
                        name="name"
                        placeholder="e.g Electronics"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3
                               focus:ring-2 focus:ring-blue-500
                               focus:border-blue-500
                               outline-none transition">

                </input>

                </div>

                <!-- DESCRIPTION -->
                <div>

                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Description
                    </label>

                    <textarea
                        name="description"
                        rows="5"
                        placeholder="Write category description..."
                        class="w-full border border-gray-300 rounded-xl px-4 py-3
                               focus:ring-2 focus:ring-blue-500
                               focus:border-blue-500
                               outline-none transition resize-none"></textarea>

                </div>

                <!-- ACTIONS -->
                <div class="flex flex-col sm:flex-row gap-4 pt-2">

                    <!-- SAVE BUTTON -->
                    <button type="submit"
                            class="flex-1 bg-blue-600 hover:bg-blue-700
                                   text-white font-semibold py-3 rounded-xl
                                   transition duration-200 shadow-md hover:shadow-lg">

                        Save Category

                    </button>

                    <!-- CANCEL -->
                    <a href="{{ route('admin.categories.index') }}"
                       class="flex-1 bg-gray-200 hover:bg-gray-300
                              text-gray-700 font-semibold py-3 rounded-xl
                              text-center transition duration-200">

                        Cancel

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection
