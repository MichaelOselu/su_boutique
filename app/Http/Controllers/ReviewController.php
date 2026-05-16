<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, $productId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|min:5'
        ]);

        $product = Product::findOrFail($productId);

        /*
        |--------------------------------------------------------------------------
        | CHECK VERIFIED PURCHASE
        |--------------------------------------------------------------------------
        */
        $verifiedPurchase = auth()->user()
            ->orders()
            ->where('status', 'paid')
            ->whereHas('items', function ($query) use ($productId) {
                $query->where('product_id', $productId);
            })
            ->exists();

        Review::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'verified_purchase' => $verifiedPurchase
        ]);

        return back()->with('success', 'Review submitted successfully.');
    }
}
