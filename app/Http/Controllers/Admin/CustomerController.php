<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
  use App\Models\User;

class CustomerController extends Controller
{


public function index()
{
    $customers = User::withCount('orders')
        ->latest()
        ->get();

    $totalCustomers = User::count();

    $activeCustomers = User::has('orders')->count();

    $customersWithOrders = User::has('orders')->count();

    return view('admin.customers.index', compact(
        'customers',
        'totalCustomers',
        'activeCustomers',
        'customersWithOrders'
    ));
}
}
