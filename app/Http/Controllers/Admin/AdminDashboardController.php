<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Models\Order;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // TOTAL COUNTS
        $totalProducts = Product::count();

        $totalCategories = Category::count();

        $totalUsers = User::count();

        // TOTAL REVENUE
        $totalRevenue = Order::sum('total');

        // RECENT PRODUCTS
        $recentProducts = Product::latest()
            ->take(5)
            ->get();

        // FLASH SALE PRODUCTS COUNT
        $flashSalesCount = Product::where('is_flash_sale', true)
            ->count();

        // LOW STOCK PRODUCTS COUNT
        $lowStockCount = Product::where('stock_quantity', '<', 5)
            ->count();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalCategories',
            'totalUsers',
            'totalRevenue',
            'recentProducts',
            'flashSalesCount',
            'lowStockCount'
        ));
    }
}
