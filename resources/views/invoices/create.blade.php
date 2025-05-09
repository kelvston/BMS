@extends('layouts.app')

@section('title', 'Create Invoice')

@section('content')
<div class="container mx-auto py-6 px-4">
    <h1 class="text-2xl font-bold mb-6">Create New Invoice</h1>
    
    <form action="{{ route('invoices.store') }}" method="POST" id="invoice-form">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Left Column -->
            <div class="space-y-6">
                <!-- Customer Selection -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold mb-4">Customer Information</h2>
                    <div class="mb-4">
                        <label for="customer_id" class="block text-gray-700 mb-2">Customer *</label>
                        <select name="customer_id" id="customer_id" class="w-full px-3 py-2 border rounded" required>
                            <option value="">-- Select Customer --</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }} ({{ $customer->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('customer_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Invoice Details -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold mb-4">Invoice Details</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="invoice_date" class="block text-gray-700 mb-2">Invoice Date *</label>
                            <input type="date" name="invoice_date" id="invoice_date" 
                                   value="{{ old('invoice_date', now()->format('Y-m-d')) }}"
                                   class="w-full px-3 py-2 border rounded" required>
                            @error('invoice_date')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="due_date" class="block text-gray-700 mb-2">Due Date *</label>
                            <input type="date" name="due_date" id="due_date" 
                                   value="{{ old('due_date', now()->addDays(30)->format('Y-m-d')) }}"
                                   class="w-full px-3 py-2 border rounded" required>
                            @error('due_date')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right Column -->
            <div class="space-y-6">
                <!-- Financial Details -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold mb-4">Financial Details</h2>
                    
                    <div class="mb-4">
                        <label for="tax_rate" class="block text-gray-700 mb-2">Tax Rate (%) *</label>
                        <input type="number" name="tax_rate" id="tax_rate" min="0" max="30" step="0.01"
                               value="{{ old('tax_rate', 0) }}"
                               class="w-full px-3 py-2 border rounded" required>
                        @error('tax_rate')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="discount" class="block text-gray-700 mb-2">Discount ($)</label>
                        <input type="number" name="discount" id="discount" min="0" step="0.01"
                               value="{{ old('discount', 0) }}"
                               class="w-full px-3 py-2 border rounded">
                        @error('discount')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="space-y-2 pt-4 border-t border-gray-200">
                        <div class="flex justify-between">
                            <span class="font-medium">Subtotal:</span>
                            <span id="subtotal-display">$0.00</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium">Tax:</span>
                            <span id="tax-display">$0.00</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium">Discount:</span>
                            <span id="discount-display">$0.00</span>
                        </div>
                        <div class="flex justify-between font-bold text-lg pt-2">
                            <span>Total:</span>
                            <span id="total-display">$0.00</span>
                        </div>
                    </div>
                </div>
                
                <!-- Status Selection -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold mb-4">Invoice Status</h2>
                    <select name="status" id="status" class="w-full px-3 py-2 border rounded">
                        <option value="unpaid" {{ old('status', 'unpaid') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                        <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="partial" {{ old('status') == 'partial' ? 'selected' : '' }}>Partial Payment</option>
                    </select>
                </div>
            </div>
        </div>
        
        <!-- Invoice Items Section -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-lg font-semibold mb-4">Invoice Items</h2>
            
            <div id="items-container">
                <!-- Initial Item Row -->
                <div class="item-row grid grid-cols-12 gap-4 mb-4">
                    <div class="col-span-5">
                        <select name="items[0][product_id]" class="product-select w-full px-3 py-2 border rounded" required>
                            <option value="">-- Select Product --</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" 
                                        data-price="{{ $product->price }}"
                                        {{ old('items.0.product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }} (${{ number_format($product->price, 2) }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-span-2">
                        <input type="number" name="items[0][quantity]" min="1" value="{{ old('items.0.quantity', 1) }}" 
                               class="quantity w-full px-3 py-2 border rounded" required>
                    </div>
                    <div class="col-span-3">
                        <input type="text" class="price w-full px-3 py-2 border bg-gray-100 rounded" readonly>
                    </div>
                    <div class="col-span-2">
                        <button type="button" class="remove-item bg-red-500 text-white px-3 py-2 rounded hover:bg-red-600">
                            Remove
                        </button>
                    </div>
                </div>
            </div>
            
            <button type="button" id="add-item" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mt-4">
                Add Item
            </button>
        </div>
        
        <div class="flex justify-end space-x-4">
            <a href="{{ route('invoices.index') }}" class="bg-gray-200 text-gray-800 px-6 py-2 rounded hover:bg-gray-300">
                Cancel
            </a>
            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                Create Invoice
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add new item row
    document.getElementById('add-item').addEventListener('click', function() {
        const container = document.getElementById('items-container');
        const itemCount = document.querySelectorAll('.item-row').length;
        const newRow = document.querySelector('.item-row').cloneNode(true);
        
        // Update indexes
        newRow.innerHTML = newRow.innerHTML.replace(/items\[0\]/g, `items[${itemCount}]`);
        
        // Clear values
        newRow.querySelector('.product-select').value = '';
        newRow.querySelector('.quantity').value = 1;
        newRow.querySelector('.price').value = '';
        
        container.appendChild(newRow);
    });
    
    // Remove item row
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-item')) {
            if (document.querySelectorAll('.item-row').length > 1) {
                e.target.closest('.item-row').remove();
                calculateTotals();
            }
        }
    });
    
    // Calculate prices when product or quantity changes
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('product-select') || e.target.classList.contains('quantity')) {
            updateItemPrice(e.target.closest('.item-row'));
            calculateTotals();
        }
    });
    
    // Calculate when tax or discount changes
    document.getElementById('tax_rate').addEventListener('change', calculateTotals);
    document.getElementById('discount').addEventListener('change', calculateTotals);
    
    // Initialize calculations
    calculateTotals();
    
    // Update individual item price
    function updateItemPrice(row) {
        const productSelect = row.querySelector('.product-select');
        const quantityInput = row.querySelector('.quantity');
        const priceField = row.querySelector('.price');
        
        if (productSelect.value && quantityInput.value) {
            const price = productSelect.options[productSelect.selectedIndex].dataset.price;
            const total = (price * quantityInput.value).toFixed(2);
            priceField.value = '$' + total;
        } else {
            priceField.value = '';
        }
    }
    
    // Calculate all totals
    function calculateTotals() {
        let subtotal = 0;
        
        // Calculate subtotal from all items
        document.querySelectorAll('.item-row').forEach(row => {
            const priceText = row.querySelector('.price').value;
            if (priceText) {
                subtotal += parseFloat(priceText.replace('$', ''));
            }
        });
        
        // Get tax and discount values
        const taxRate = parseFloat(document.getElementById('tax_rate').value) || 0;
        const discount = parseFloat(document.getElementById('discount').value) || 0;
        
        // Calculate tax and total
        const taxAmount = subtotal * (taxRate / 100);
        const total = subtotal + taxAmount - discount;
        
        // Update display
        document.getElementById('subtotal-display').textContent = '$' + subtotal.toFixed(2);
        document.getElementById('tax-display').textContent = '$' + taxAmount.toFixed(2);
        document.getElementById('discount-display').textContent = '-$' + discount.toFixed(2);
        document.getElementById('total-display').textContent = '$' + total.toFixed(2);
    }
});
</script>
@endsection