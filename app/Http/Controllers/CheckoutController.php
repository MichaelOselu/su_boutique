<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;

class CheckoutController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CHECKOUT PAGE
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $cart = session()->get('cart', []);

        // Prevent empty checkout
        if (count($cart) == 0) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty');
        }

        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('shop.checkout', compact('cart', 'total'));
    }

    /*
    |--------------------------------------------------------------------------
    | PLACE ORDER
    |--------------------------------------------------------------------------
    */

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'phone' => 'required|string|max:20',
        'address' => 'required|string',

        // GOOGLE MAP / LOCATION FIELDS
        'latitude' => 'required',
        'longitude' => 'required',
    ]);

    $cart = session()->get('cart', []);

    if (count($cart) == 0) {
        return redirect()->route('cart.index');
    }

    /*
    |--------------------------------------------------------------------------
    | CALCULATE TOTAL
    |--------------------------------------------------------------------------
    */

    $total = 0;

    foreach ($cart as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE ORDER
    |--------------------------------------------------------------------------
    */

    $order = Order::create([
        'user_id' => auth()->check() ? auth()->id() : null,

        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'address' => $request->address,

        // SAVE MAP COORDINATES
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,

        'total' => $total,
        'status' => 'pending',
    ]);

    /*
    |--------------------------------------------------------------------------
    | CREATE ORDER ITEMS
    |--------------------------------------------------------------------------
    */

    foreach ($cart as $productId => $item) {

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $productId,
            'price' => $item['price'],
            'quantity' => $item['quantity'],
            'subtotal' => $item['price'] * $item['quantity'],
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | CLEAR CART
    |--------------------------------------------------------------------------
    */

    session()->forget('cart');

    /*
    |--------------------------------------------------------------------------
    | REDIRECT
    |--------------------------------------------------------------------------
    */

    return redirect()->route('checkout.success', $order->id);
}

    /*
    |--------------------------------------------------------------------------
    | ORDER SUCCESS PAGE
    |--------------------------------------------------------------------------
    */

    public function success($id)
    {
        $order = Order::with('items.product')->findOrFail($id);

        return view('shop.success', compact('order'));
    }

    public function myOrders()
{
    $orders = Order::with('items.product')
        ->where('user_id', auth()->id())
        ->latest()
        ->get();

    return view('shop.orders.index', compact('orders'));
}

public function orderShow($id)
{
    $order = Order::with('items.product')
        ->where('user_id', auth()->id())
        ->findOrFail($id);

    return view('shop.orders.show', compact('order'));
}
}
