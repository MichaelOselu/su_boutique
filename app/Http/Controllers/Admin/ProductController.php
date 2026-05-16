<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

            'sale_price' => 'nullable|numeric',
            'is_flash_sale' => 'nullable',
            'sale_ends_at' => 'nullable',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {

            $file = $request->file('image');

            $filename = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('uploads/products'), $filename);

            $imagePath = $filename;
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

            'sale_price' => 'nullable|numeric',
            'is_flash_sale' => 'nullable',
            'sale_ends_at' => 'nullable',
        ]);

        $imagePath = $product->image;

        if ($request->hasFile('image')) {

            // delete old image
            if ($product->image && file_exists(public_path('uploads/products/' . $product->image))) {
                unlink(public_path('uploads/products/' . $product->image));
            }

            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/products'), $filename);

            $imagePath = $filename;
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

            'sale_price' => $request->sale_price,
            'is_flash_sale' => $request->has('is_flash_sale'),
            'sale_ends_at' => $request->sale_ends_at,
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        if ($product->image && file_exists(public_path('uploads/products/' . $product->image))) {
            unlink(public_path('uploads/products/' . $product->image));
        }

        $product->delete();

        return back()->with('success', 'Product deleted successfully');
    }
}
