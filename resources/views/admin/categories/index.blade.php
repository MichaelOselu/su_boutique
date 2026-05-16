@extends('admin.layout')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Categories</h1>

    <a href="{{ route('admin.categories.create') }}"
       class="bg-blue-500 text-white px-4 py-2 rounded">
        + Add Category
    </a>
</div>

@if(session('success'))
    <div class="mb-4 bg-green-100 text-green-700 p-3 rounded">
        {{ session('success') }}
    </div>
@endif

<table class="w-full bg-white shadow rounded">

    <thead class="bg-gray-200">
        <tr>
            <th class="p-3 text-left">ID</th>
            <th class="p-3 text-left">Name</th>
            <th class="p-3 text-left">Slug</th>
            <th class="p-3 text-left">Actions</th>
        </tr>
    </thead>

    <tbody>

        @foreach($categories as $category)
        <tr class="border-t">

            <td class="p-3">{{ $category->id }}</td>

            <td class="p-3 font-medium">
                {{ $category->name }}
            </td>

            <td class="p-3 text-gray-600">
                {{ $category->slug }}
            </td>

            <td class="p-3 space-x-2">

                <a href="{{ route('admin.categories.edit', $category->id) }}"
                   class="text-blue-600">
                    Edit
                </a>

                <a href="{{ route('admin.categories.products', $category->id) }}"
                class="text-green-600 font-medium">
                    View Products
                </a>

                <form action="{{ route('admin.categories.destroy', $category->id) }}"
                      method="POST"
                      class="inline"
                      onsubmit="return confirm('Are you sure you want to delete this category?')">

                    @csrf
                    @method('DELETE')

                    <button class="text-red-600">
                        Delete
                    </button>

                </form>

            </td>

        </tr>
        @endforeach

    </tbody>

</table>

@endsection
