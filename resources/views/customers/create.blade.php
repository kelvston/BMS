@extends('layouts.app')

@section('title', 'Add New Customer')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-lg shadow p-6">
    <h1 class="text-2xl font-bold mb-6">Add New Customer</h1>
    
    <form action="{{ route('customers.store') }}" method="POST">
        @csrf
        
        <div class="mb-4">
            <label for="name" class="block text-gray-700 mb-2">Full Name</label>
            <input type="text" name="name" id="name" class="w-full px-3 py-2 border rounded" required>
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-4">
            <label for="email" class="block text-gray-700 mb-2">Email</label>
            <input type="email" name="email" id="email" class="w-full px-3 py-2 border rounded" required>
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-4">
            <label for="phone" class="block text-gray-700 mb-2">Phone</label>
            <input type="text" name="phone" id="phone" class="w-full px-3 py-2 border rounded" required>
            @error('phone')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-4">
            <label for="company_name" class="block text-gray-700 mb-2">Company (Optional)</label>
            <input type="text" name="company_name" id="company_name" class="w-full px-3 py-2 border rounded">
        </div>
        
        <div class="mb-6">
            <label for="address" class="block text-gray-700 mb-2">Address (Optional)</label>
            <textarea name="address" id="address" rows="3" class="w-full px-3 py-2 border rounded"></textarea>
        </div>
        
        <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">
            Save Customer
        </button>
        
        <div class="mt-4 text-center">
            <a href="{{ route('customers.index') }}" class="text-blue-600 hover:underline">Back to Customers</a>
        </div>
    </form>
</div>
@endsection