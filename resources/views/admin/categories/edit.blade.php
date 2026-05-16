@extends('admin.layout')

@section('content')

<div class="min-h-screen flex items-center justify-center px-4 py-10">

    <div class="w-full max-w-3xl">

        <!-- CARD -->
        <div class="bg-white shadow-2xl rounded-3xl overflow-hidden border border-gray-100">

            <!-- HEADER -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-6 sm:px-10 py-8">

                <h1 class="text-3xl sm:text-4xl font-bold text-white">
                    Edit Category
                </h1>

                <p class="text-blue-100 mt-2 text-sm sm:text-base">
                    Update category information and description
                </p>

            </div>

            <!-- FORM -->
            <form method="POST"
                  action="{{ route('admin.categories.update', $category) }}"
                  class="p-6 sm:p-10 space-y-8">

                @csrf
                @method('PUT')

                <!-- CATEGORY DETAILS -->
                <div class="bg-gray-50 border border-gray-200 rounded-2xl p-6 sm:p-8">

                    <div class="mb-6">

                        <h2 class="text-xl font-bold text-gray-800">
                            Category Details
                        </h2>

                        <p class="text-sm text-gray-500 mt-1">
                            Update the category name and description
                        </p>

                    </div>

                    <div class="space-y-6">

                        <!-- NAME -->
                        <div>

                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Category Name
                            </label>

                            <input type="text"
                                   name="name"
                                   value="{{ $category->name }}"
                                   placeholder="e.g Electronics"
                                   class="w-full border border-gray-300 rounded-xl px-4 py-4
                                          focus:ring-2 focus:ring-blue-500
                                          focus:border-blue-500
                                          outline-none transition">

                        </div>

                        <!-- DESCRIPTION -->
                        <div>

                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Description
                            </label>

                            <textarea name="description"
                                      rows="6"
                                      placeholder="Write category description..."
                                      class="w-full border border-gray-300 rounded-xl px-4 py-4
                                             focus:ring-2 focus:ring-blue-500
                                             focus:border-blue-500
                                             outline-none transition resize-none">{{ $category->description }}</textarea>

                        </div>

                    </div>

                </div>

                <!-- ACTION BUTTONS -->
                <div class="flex flex-col sm:flex-row gap-4">

                    <!-- UPDATE -->
                    <button type="submit"
                            class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-700
                                   hover:from-blue-700 hover:to-indigo-800
                                   text-white font-bold py-4 rounded-2xl
                                   transition duration-200 shadow-lg hover:shadow-xl">

                        Update Category

                    </button>

                    <!-- CANCEL -->
                    <a href="{{ route('admin.categories.index') }}"
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
