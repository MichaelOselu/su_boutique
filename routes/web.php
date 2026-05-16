<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\MpesaController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\WishlistController;

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SalesController;
use App\Http\Controllers\Admin\CustomerController;

use App\Models\User;
use Illuminate\Support\Facades\Hash;





Route::get('/create-admin-temp', function () {

    $user = User::create([
        'name' => 'Admin',
        'email' => 'admin@shop.com',
        'password' => Hash::make('password123'),
        'role' => 'admin' // remove if you don’t have this column
    ]);

    return "Admin created successfully!";
});

/*
|--------------------------------------------------------------------------
| PUBLIC STORE ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', [ShopController::class, 'index'])
    ->name('home');

Route::get('/shop', [ShopController::class, 'shop'])
    ->name('shop');

Route::get('/product/{slug}', [ShopController::class, 'show'])
    ->name('product.show');

/*
|--------------------------------------------------------------------------
| SEARCH SYSTEM
|--------------------------------------------------------------------------
*/

Route::get('/search', [ShopController::class, 'search'])
    ->name('shop.search');

/*
|--------------------------------------------------------------------------
| CART ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/cart', [CartController::class, 'index'])
    ->name('cart.index');

Route::post('/cart/add/{product}', [CartController::class, 'add'])
    ->name('cart.add');

Route::post('/cart/update/{id}', [CartController::class, 'update'])
    ->name('cart.update');

Route::post('/cart/remove/{id}', [CartController::class, 'remove'])
    ->name('cart.remove');

/*
|--------------------------------------------------------------------------
| AUTHENTICATED CUSTOMER ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | CHECKOUT
    |--------------------------------------------------------------------------
    */

    Route::get('/checkout', [CheckoutController::class, 'index'])
        ->name('checkout.index');

    Route::post('/checkout', [CheckoutController::class, 'store'])
        ->name('checkout.store');

    Route::get('/checkout/success/{id}', [CheckoutController::class, 'success'])
        ->name('checkout.success');



    /*
    |--------------------------------------------------------------------------
    | CUSTOMER ORDERS
    |--------------------------------------------------------------------------
    */

    Route::get('/my-orders', [CheckoutController::class, 'myOrders'])
        ->name('orders.my');

    Route::get('/my-orders/{id}', [CheckoutController::class, 'orderShow'])
        ->name('orders.show');

    /*
    |--------------------------------------------------------------------------
    | PRODUCT REVIEWS
    |--------------------------------------------------------------------------
    */

    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])
        ->name('reviews.store');

    /*
    |--------------------------------------------------------------------------
    | WISHLIST
    |--------------------------------------------------------------------------
    */

    Route::get('/wishlist', [WishlistController::class, 'index'])
        ->name('wishlist.index');

    Route::post('/wishlist/{product}', [WishlistController::class, 'store'])
        ->name('wishlist.store');

    Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy'])
        ->name('wishlist.destroy');

    /*
    |--------------------------------------------------------------------------
    | M-PESA PAYMENT
    |--------------------------------------------------------------------------
    */

    Route::post('/mpesa/stk/{order}', [MpesaController::class, 'stk'])
        ->name('mpesa.stk');

    /*
    |--------------------------------------------------------------------------
    | CUSTOMER DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| M-PESA CALLBACK
|--------------------------------------------------------------------------
|
| IMPORTANT:
| Safaricom calls this route directly.
| NEVER protect this route with auth middleware.
|
*/

Route::post('/mpesa/callback', [MpesaController::class, 'callback'])
    ->name('mpesa.callback');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        /*
        |--------------------------------------------------------------------------
        | PRODUCTS
        |--------------------------------------------------------------------------
        */

        Route::resource('products', ProductController::class);

        /*
        |--------------------------------------------------------------------------
        | CATEGORIES
        |--------------------------------------------------------------------------
        */

        Route::resource('categories', CategoryController::class);

        Route::get(
            'categories/{category}/products',
            [CategoryController::class, 'products']
        )->name('categories.products');

        /*
        |--------------------------------------------------------------------------
        | ORDERS MANAGEMENT
        |--------------------------------------------------------------------------
        */

        Route::get('/orders', [OrderController::class, 'index'])
            ->name('orders.index');

        Route::get('/orders/{order}', [OrderController::class, 'show'])
            ->name('orders.show');

        Route::post('/orders/{order}/status', [OrderController::class, 'updateStatus'])
            ->name('orders.updateStatus');



        Route::get('/sales', [SalesController::class, 'index'])
            ->name('sales.index');



        Route::get('/customers', [CustomerController::class, 'index'])
            ->name('customers.index');
    });

require __DIR__.'/auth.php';
