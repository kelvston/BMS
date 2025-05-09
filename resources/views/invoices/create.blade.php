@extends('layouts.app')

@section('title', 'Create Invoice')

@section('content')
    <div class="glass p-8 mx-auto max-w-7xl" style="transform-style: preserve-3d;">
        <h1 class="text-3xl font-bold mb-6 text-white">Create New Invoice</h1>

        <form action="{{ route('invoices.store') }}" method="POST" id="invoice-form" class="space-y-8">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Left Column -->
                <div class="space-y-6">
                    <!-- Customer Selection -->
                    <div class="glass-card p-6">
                        <h2 class="text-lg font-semibold mb-4 text-cyan-100">Customer Information</h2>
                        <div class="mb-4">
                            <label for="customer_id" class="block text-cyan-100 mb-2">Customer *</label>
                            <select name="customer_id" id="customer_id"
                                    class="w-full glass-input"
                                    required>
                                <option value="">-- Select Customer --</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }} ({{ $customer->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('customer_id')
                            <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Invoice Details -->
                    <div class="glass-card p-6">
                        <h2 class="text-lg font-semibold mb-4 text-cyan-100">Invoice Details</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="invoice_date" class="block text-cyan-100 mb-2">Invoice Date *</label>
                                <input type="date" name="invoice_date" id="invoice_date"
                                       value="{{ old('invoice_date', now()->format('Y-m-d')) }}"
                                       class="glass-input"
                                       required>
                                @error('invoice_date')
                                <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="due_date" class="block text-cyan-100 mb-2">Due Date *</label>
                                <input type="date" name="due_date" id="due_date"
                                       value="{{ old('due_date', now()->addDays(30)->format('Y-m-d')) }}"
                                       class="glass-input"
                                       required>
                                @error('due_date')
                                <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <!-- Financial Details -->
                    <div class="glass-card p-6">
                        <h2 class="text-lg font-semibold mb-4 text-cyan-100">Financial Details</h2>

                        <div class="mb-4">
                            <label for="tax_rate" class="block text-cyan-100 mb-2">Tax Rate (%) *</label>
                            <input type="number" name="tax_rate" id="tax_rate" min="0" max="30" step="0.01"
                                   value="{{ old('tax_rate', 0) }}"
                                   class="glass-input"
                                   required>
                            @error('tax_rate')
                            <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="discount" class="block text-cyan-100 mb-2">Discount ($)</label>
                            <input type="number" name="discount" id="discount" min="0" step="0.01"
                                   value="{{ old('discount', 0) }}"
                                   class="glass-input">
                            @error('discount')
                            <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2 pt-4 border-t border-cyan-800">
                            <div class="flex justify-between text-cyan-100">
                                <span class="font-medium">Subtotal:</span>
                                <span id="subtotal-display">$0.00</span>
                            </div>
                            <div class="flex justify-between text-cyan-100">
                                <span class="font-medium">Tax:</span>
                                <span id="tax-display">$0.00</span>
                            </div>
                            <div class="flex justify-between text-cyan-100">
                                <span class="font-medium">Discount:</span>
                                <span id="discount-display">$0.00</span>
                            </div>
                            <div class="flex justify-between font-bold text-lg pt-2 text-white">
                                <span>Total:</span>
                                <span id="total-display">$0.00</span>
                            </div>
                        </div>
                    </div>

                    <!-- Status Selection -->
                    <div class="glass-card p-6">
                        <h2 class="text-lg font-semibold mb-4 text-cyan-100">Invoice Status</h2>
                        <select name="status" id="status" class="glass-input">
                            <option value="unpaid" {{ old('status', 'unpaid') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                            <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="partial" {{ old('status') == 'partial' ? 'selected' : '' }}>Partial Payment</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Invoice Items Section -->
            <div class="glass-card p-6">
                <h2 class="text-lg font-semibold mb-4 text-cyan-100">Invoice Items</h2>

                <div id="items-container" class="space-y-4">
                    <!-- Initial Item Row -->
                    <div class="item-row glass-card p-4 grid grid-cols-12 gap-4">
                        <div class="col-span-5">
                            <select name="items[0][product_id]" class="glass-input product-select" required>
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
                            <input type="number" name="items[0][quantity]" min="1"
                                   value="{{ old('items.0.quantity', 1) }}"
                                   class="glass-input quantity" required>
                        </div>
                        <div class="col-span-3">
                            <input type="text" name="items[0][price]"
                                   class="glass-input bg-white/10 price" readonly>
                        </div>
                        <div class="col-span-2 flex items-center">
                            <button type="button" class="glass-btn-danger remove-item py-2 px-3">
                                Remove
                            </button>
                        </div>
                    </div>
                </div>

                <button type="button" id="add-item" class="glow-btn mt-4">
                    Add Item
                </button>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('invoices.index') }}" class="glass-btn-secondary">
                    Cancel
                </a>
                <button type="submit" class="glow-btn bg-green-600/30 hover:bg-green-600/50">
                    Create Invoice
                </button>
            </div>
        </form>
    </div>

    <style>
        .glass {
            background: rgba(16, 24, 39, 0.9);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 0.75rem;
            backdrop-filter: blur(8px);
        }

        .glass-input {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(6, 182, 212, 0.3);
            color: white;
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .glass-input:focus {
            border-color: rgba(6, 182, 212, 0.6);
            box-shadow: 0 0 15px rgba(6, 182, 212, 0.2);
        }

        .glow-btn {
            background: rgba(6, 182, 212, 0.15);
            border: 1px solid rgba(6, 182, 212, 0.3);
            color: #a5f3fc;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .glow-btn:hover {
            border-color: rgba(6, 182, 212, 0.6);
            box-shadow: 0 0 15px rgba(6, 182, 212, 0.2);
        }

        .glass-btn-secondary {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .glass-btn-danger {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: rgb(239, 68, 68);
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .glass-btn-danger:hover {
            border-color: rgba(239, 68, 68, 0.6);
            background: rgba(239, 68, 68, 0.2);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let itemCount = 0;
            const itemsContainer = document.getElementById('items-container');
            const addItemBtn = document.getElementById('add-item');

            // Add new item row
            addItemBtn.addEventListener('click', function() {
                const newRow = document.querySelector('.item-row').cloneNode(true);
                itemCount++;

                // Update all names and IDs
                newRow.innerHTML = newRow.innerHTML.replace(/items\[0\]/g, `items[${itemCount}]`);

                // Clear values
                newRow.querySelector('.product-select').value = '';
                newRow.querySelector('.quantity').value = 1;
                newRow.querySelector('.price').value = '';

                itemsContainer.appendChild(newRow);
                attachItemEvents(newRow);
            });

            // Remove item row
            itemsContainer.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-item')) {
                    if (document.querySelectorAll('.item-row').length > 1) {
                        e.target.closest('.item-row').remove();
                        calculateTotals();
                    }
                }
            });

            // Calculate totals when any input changes
            document.addEventListener('input', function(e) {
                if (e.target.matches('.product-select, .quantity, #tax_rate, #discount')) {
                    updateItemPrice(e.target.closest('.item-row'));
                    calculateTotals();
                }
            });

            // Initialize calculations
            calculateTotals();

            function attachItemEvents(row) {
                row.querySelector('.product-select').addEventListener('change', function() {
                    updateItemPrice(row);
                    calculateTotals();
                });

                row.querySelector('.quantity').addEventListener('input', function() {
                    updateItemPrice(row);
                    calculateTotals();
                });
            }

            function updateItemPrice(row) {
                const productSelect = row.querySelector('.product-select');
                const quantityInput = row.querySelector('.quantity');
                const priceField = row.querySelector('.price');

                if (productSelect.value && quantityInput.value) {
                    const price = productSelect.options[productSelect.selectedIndex].dataset.price;
                    const total = (parseFloat(price) * parseInt(quantityInput.value)).toFixed(2);
                    priceField.value = total; // Store numeric value
                } else {
                    priceField.value = '';
                }
            }

            function calculateTotals() {
                let subtotal = 0;

                document.querySelectorAll('.item-row').forEach(row => {
                    const priceValue = row.querySelector('.price').value;
                    if (priceValue) {
                        subtotal += parseFloat(priceValue);
                    }
                });

                const taxRate = parseFloat(document.getElementById('tax_rate').value) || 0;
                const discount = parseFloat(document.getElementById('discount').value) || 0;
                const taxAmount = subtotal * (taxRate / 100);
                const total = subtotal + taxAmount - discount;

                // Update displays with formatted values
                document.getElementById('subtotal-display').textContent = `$${subtotal.toFixed(2)}`;
                document.getElementById('tax-display').textContent = `$${taxAmount.toFixed(2)}`;
                document.getElementById('discount-display').textContent = `-$${discount.toFixed(2)}`;
                document.getElementById('total-display').textContent = `$${total.toFixed(2)}`;
            }
        });
    </script>
@endsection
