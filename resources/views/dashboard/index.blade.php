@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Dashboard Overview</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Stats Cards -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-gray-500 text-sm font-medium">Total Customers</h3>
            <p class="text-2xl font-bold mt-2">{{ $customersCount }}</p>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-gray-500 text-sm font-medium">Pending Invoices</h3>
            <p class="text-2xl font-bold mt-2">{{ $pendingInvoices }}</p>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-gray-500 text-sm font-medium">Revenue This Month</h3>
            <p class="text-2xl font-bold mt-2">${{ number_format($monthlyRevenue, 2) }}</p>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-gray-500 text-sm font-medium">Total Products</h3>
            <p class="text-2xl font-bold mt-2">{{ $productsCount }}</p>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-gray-500 text-sm font-medium">Low Stock Items</h3>
            <p class="text-2xl font-bold mt-2 {{ $lowStockProducts > 0 ? 'text-red-600' : 'text-green-600' }}">
                {{ $lowStockProducts }}
            </p>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-gray-500 text-sm font-medium">Active Suppliers</h3>
            <p class="text-2xl font-bold mt-2">{{ $suppliersCount ?? 0 }}</p>
        </div>
        
        <!-- Recent Activities -->
        <div class="md:col-span-2 bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-bold mb-4">Recent Activities</h2>
            <div class="space-y-4">
                @forelse($recentActivities as $activity)
                    <div class="border-b pb-2">
                        <div class="flex justify-between">
                            <p class="text-sm font-medium">{{ $activity->description }}</p>
                            <span class="text-xs text-gray-500">{{ $activity->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-xs text-gray-500">By {{ $activity->user->name }}</p>
                    </div>
                @empty
                    <p class="text-gray-500">No recent activities</p>
                @endforelse
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-bold mb-4">Quick Actions</h2>
            <div class="space-y-3">
                <a href="{{ route('invoices.create') }}" class="flex items-center px-4 py-2 bg-blue-100 text-blue-700 rounded hover:bg-blue-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/>
                    </svg>
                    Create Invoice
                </a>
                
                <a href="{{ route('customers.create') }}" class="flex items-center px-4 py-2 bg-green-100 text-green-700 rounded hover:bg-green-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    Add Customer
                </a>
                
                <a href="{{ route('products.create') }}" class="flex items-center px-4 py-2 bg-purple-100 text-purple-700 rounded hover:bg-purple-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    Add Product
                </a>

                @if($lowStockProducts > 0)
                    <a href="{{ route('products.index', ['filter' => 'low_stock']) }}" 
                       class="flex items-center px-4 py-2 bg-red-100 text-red-700 rounded hover:bg-red-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        View Low Stock ({{ $lowStockProducts }})
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection