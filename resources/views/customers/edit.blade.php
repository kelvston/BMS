@extends('layouts.app')

@section('title', 'Edit Customer')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-lg shadow p-6">
    <h1 class="text-2xl font-bold mb-6">Edit Customer</h1>
    
    <form action="{{ route('customers.update', $customer) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label for="name" class="block text-gray-700 mb-2">Full Name</label>
            <input type="text" name="name" id="name" 
                   value="{{ old('name', $customer->name) }}"
                   class="w-full px-3 py-2 border rounded" required>
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-4">
            <label for="email" class="block text-gray-700 mb-2">Email</label>
            <input type="email" name="email" id="email"
                   value="{{ old('email', $customer->email) }}"
                   class="w-full px-3 py-2 border rounded" required>
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-4">
            <label for="phone" class="block text-gray-700 mb-2">Phone</label>
            <input type="text" name="phone" id="phone"
                   value="{{ old('phone', $customer->phone) }}"
                   class="w-full px-3 py-2 border rounded" required>
            @error('phone')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-4">
            <label for="company_name" class="block text-gray-700 mb-2">Company</label>
            <input type="text" name="company_name" id="company_name"
                   value="{{ old('company_name', $customer->company_name) }}"
                   class="w-full px-3 py-2 border rounded">
        </div>
        
        <div class="mb-6">
            <label for="address" class="block text-gray-700 mb-2">Address</label>
            <textarea name="address" id="address" rows="3"
                      class="w-full px-3 py-2 border rounded">{{ old('address', $customer->address) }}</textarea>
        </div>
        
        <div class="flex justify-between">
            <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">
                Update Customer
            </button>
            
            <a href="{{ route('customers.index') }}" class="bg-gray-200 text-gray-800 py-2 px-4 rounded hover:bg-gray-300">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection