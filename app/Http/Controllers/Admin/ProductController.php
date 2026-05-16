<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'price' => 'required|numeric',
        'category_id' => 'required',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

        // STEP 7
        'sale_price' => 'nullable|numeric',
        'is_flash_sale' => 'nullable',
        'sale_ends_at' => 'nullable',
    ]);

    $imagePath = null;

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('products', 'public');
    }

    Product::create([
        'category_id' => $request->category_id,
        'name' => $request->name,
        'slug' => Str::slug($request->name),
        'description' => $request->description,
        'price' => $request->price,
        'discount_price' => $request->discount_price,
        'stock_quantity' => $request->stock_quantity,
        'image' => $imagePath,
        'is_active' => $request->is_active ?? true,

        // STEP 8
        'sale_price' => $request->sale_price,
        'is_flash_sale' => $request->has('is_flash_sale'),
        'sale_ends_at' => $request->sale_ends_at,
    ]);

    return redirect()->route('admin.products.index')
        ->with('success', 'Product created successfully');
}

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

public function update(Request $request, Product $product)
{
    $request->validate([
        'name' => 'required',
        'price' => 'required|numeric',
        'category_id' => 'required',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

        // STEP 7
        'sale_price' => 'nullable|numeric',
        'is_flash_sale' => 'nullable',
        'sale_ends_at' => 'nullable',
    ]);

    $imagePath = $product->image;

    if ($request->hasFile('image')) {

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $imagePath = $request->file('image')->store('products', 'public');
    }

    $product->update([
        'category_id' => $request->category_id,
        'name' => $request->name,
        'slug' => Str::slug($request->name),
        'description' => $request->description,
        'price' => $request->price,
        'discount_price' => $request->discount_price,
        'stock_quantity' => $request->stock_quantity,
        'image' => $imagePath,
        'is_active' => $request->is_active ?? true,

        // STEP 8
        'sale_price' => $request->sale_price,
        'is_flash_sale' => $request->has('is_flash_sale'),
        'sale_ends_at' => $request->sale_ends_at,
    ]);

    return redirect()->route('admin.products.index')
        ->with('success', 'Product updated successfully');
}

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return back()->with('success', 'Product deleted successfully');
    }
}
