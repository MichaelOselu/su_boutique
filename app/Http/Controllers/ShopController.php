<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        $products = Product::where('is_active', 1)->latest()->take(8)->get();
        $categories = Category::where('is_active', 1)->get();
        $flashSales = Product::where('is_flash_sale', true)->latest()->take(8)->get();

        return view('shop.index', compact('products', 'categories', 'flashSales'));
    }

public function shop(Request $request)
{
    $query = Product::query();

    /*
    |--------------------------------------------------------------------------
    | SEARCH
    |--------------------------------------------------------------------------
    */
    if ($request->search) {

        $query->where(function($q) use ($request) {

            $q->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('description', 'like', '%' . $request->search . '%');

        });
    }

    /*
    |--------------------------------------------------------------------------
    | CATEGORY FILTER
    |--------------------------------------------------------------------------
    */
    if ($request->category) {

        $query->where('category_id', $request->category);
    }

    /*
    |--------------------------------------------------------------------------
    | PRICE FILTERS
    |--------------------------------------------------------------------------
    */
    if ($request->min_price) {

        $query->where('price', '>=', $request->min_price);
    }

    if ($request->max_price) {

        $query->where('price', '<=', $request->max_price);
    }

    /*
    |--------------------------------------------------------------------------
    | SORTING
    |--------------------------------------------------------------------------
    */
    switch ($request->sort) {

        case 'price_low':
            $query->orderBy('price', 'asc');
            break;

        case 'price_high':
            $query->orderBy('price', 'desc');
            break;

        case 'latest':
            $query->latest();
            break;

        default:
            $query->latest();
            break;
    }

    /*
    |--------------------------------------------------------------------------
    | PAGINATION
    |--------------------------------------------------------------------------
    */
    $products = $query->paginate(12)->withQueryString();

    /*
    |--------------------------------------------------------------------------
    | CATEGORIES
    |--------------------------------------------------------------------------
    */
    $categories = \App\Models\Category::all();

    return view('shop.shop', compact('products', 'categories'));
}

public function show($slug)
{
    $product = Product::where('slug', $slug)
        ->with(['category', 'reviews.user'])
        ->firstOrFail();


        /*
    |--------------------------------------------------------------------------
    | RECENTLY VIEWED PRODUCTS
    |--------------------------------------------------------------------------
    */

    $recentlyViewed = session()->get('recently_viewed', []);

    // remove if already exists
    $recentlyViewed = array_diff($recentlyViewed, [$product->id]);

    // add current product to beginning
    array_unshift($recentlyViewed, $product->id);

    // limit to 8 products
    $recentlyViewed = array_slice($recentlyViewed, 0, 8);

    // save session
    session()->put('recently_viewed', $recentlyViewed);



    /*
    |--------------------------------------------------------------------------
    | RELATED PRODUCTS
    |--------------------------------------------------------------------------
    */
    $relatedProducts = Product::where('category_id', $product->category_id)
        ->where('id', '!=', $product->id)
        ->latest()
        ->take(4)
        ->get();

    /*
    |--------------------------------------------------------------------------
    | YOU MAY ALSO LIKE
    |--------------------------------------------------------------------------
    */
    $recommendedProducts = Product::where('id', '!=', $product->id)
        ->inRandomOrder()
        ->take(4)
        ->get();

    $averageRating = round($product->reviews->avg('rating'), 1);

    $recentProducts = Product::whereIn(
            'id',
            session('recently_viewed', [])
        )
        ->where('id', '!=', $product->id)
        ->take(8)
        ->get();

    return view('shop.product', compact(
        'product',
        'relatedProducts',
        'recommendedProducts',
        'averageRating',
        'recentProducts'
    ));
}

    public function search(Request $request)
{
    $query = $request->q;

    $products = \App\Models\Product::where('name', 'LIKE', "%{$query}%")
        ->orWhere('description', 'LIKE', "%{$query}%")
        ->paginate(12);

    return view('shop.search', compact('products', 'query'));
}
}
