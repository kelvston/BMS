<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Log;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
{
    return view('dashboard.index', [
        'customersCount' => \App\Models\Customer::count(),
        'pendingInvoices' => \App\Models\Invoice::where('status', 'unpaid')->count(),
        'monthlyRevenue' => \App\Models\Invoice::where('status', 'paid')
                               ->whereMonth('created_at', now()->month)
                               ->sum('total_amount'),
                               'productsCount' => Product::count(),
            'lowStockProducts' => Product::where('quantity', '<', 5)->count(),
        'recentActivities' => Log::latest()->take(5)->get()
    ]);
}
}
