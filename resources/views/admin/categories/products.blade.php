@extends('admin.layout')

@section('content')

<h1 class="text-2xl font-bold mb-4">
    Products in {{ $category->name }}
</h1>

<table class="w-full bg-white shadow rounded">

    <thead class="bg-gray-200">
        <tr>
            <th class="p-3 text-left">Image</th>
            <th class="p-3 text-left">Name</th>
            <th class="p-3 text-left">Price</th>
        </tr>
    </thead>

    <tbody>
        @forelse($products as $product)
        <tr class="border-t">

            <td class="p-3">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" width="50">
                @endif
            </td>

            <td class="p-3">{{ $product->name }}</td>

            <td class="p-3">KSh {{ $product->price }}</td>

        </tr>
        @empty
        <tr>
            <td colspan="3" class="p-3 text-center text-gray-500">
                No products in this category
            </td>
        </tr>
        @endforelse
    </tbody>

</table>

@endsection
