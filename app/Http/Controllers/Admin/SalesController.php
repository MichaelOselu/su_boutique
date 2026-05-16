<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;

class SalesController extends Controller
{
    public function index()
    {
        // ========================
        // TOTAL REVENUE
        // ========================
        $totalRevenue = Order::sum('total');

        // ========================
        // TOTAL ORDERS
        // ========================
        $totalOrders = Order::count();

        // ========================
        // AVERAGE ORDER VALUE
        // ========================
        $averageOrderValue = $totalOrders > 0
            ? $totalRevenue / $totalOrders
            : 0;

        // ========================
        // RECENT ORDERS (LATEST 10)
        // ========================
        $recentOrders = Order::latest()
            ->take(10)
            ->get();

        // ========================
        // RETURN VIEW
        // ========================
        return view('admin.sales.index', compact(
            'totalRevenue',
            'totalOrders',
            'averageOrderValue',
            'recentOrders'
        ));
    }
}
