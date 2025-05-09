@extends('layouts.app')

@section('title', 'Add New Product')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-lg shadow p-6">
    <h1 class="text-2xl font-bold mb-6">Add New Product</h1>
    
    <form action="{{ route('products.store') }}" method="POST">
        @csrf
        
        <div class="mb-4">
            <label for="name" class="block text-gray-700 mb-2">Product Name *</label>
            <input type="text" name="name" id="name" class="w-full px-3 py-2 border rounded" required>
        </div>
        
        <div class="mb-4">
            <label for="sku" class="block text-gray-700 mb-2">SKU *</label>
            <input type="text" name="sku" id="sku" class="w-full px-3 py-2 border rounded" required>
        </div>
        
        <div class="mb-4">
            <label for="price" class="block text-gray-700 mb-2">Price *</label>
            <input type="number" name="price" id="price" min="0" step="0.01" class="w-full px-3 py-2 border rounded" required>
        </div>
        
        <div class="mb-4">
            <label for="quantity" class="block text-gray-700 mb-2">Initial Quantity *</label>
            <input type="number" name="quantity" id="quantity" min="0" class="w-full px-3 py-2 border rounded" required>
        </div>
        
        <div class="mb-6">
            <label for="description" class="block text-gray-700 mb-2">Description</label>
            <textarea name="description" id="description" rows="3" class="w-full px-3 py-2 border rounded"></textarea>
        </div>
        <div class="mb-4">
    <label for="supplier_id" class="block text-gray-700 mb-2">Supplier</label>
    <select name="supplier_id" id="supplier_id" class="w-full px-3 py-2 border rounded">
        <option value="">-- No Supplier --</option>
        @foreach($suppliers as $supplier)
            <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                {{ $supplier->name }}
            </option>
        @endforeach
    </select>
    @error('supplier_id')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>
        
        <div class="flex justify-end space-x-4">
            <a href="{{ route('dashboard') }}" class="bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300">
                Cancel
            </a>
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Save Product
            </button>
        </div>
    </form>
</div>
@endsection