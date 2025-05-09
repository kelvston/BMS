@extends('layouts.app')

@section('title', 'Add New Product')

@section('content')
    <div class="glass-container rounded-xl shadow-2xl p-8 mx-auto max-w-md backdrop-blur-lg border border-white/10">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold bg-gradient-to-r from-green-400 to-cyan-400 bg-clip-text text-transparent">
                New Product
            </h1>
            <div class="h-1 bg-gradient-to-r from-green-400 to-cyan-400 w-20 mx-auto rounded-full mt-2"></div>
        </div>

        <form action="{{ route('products.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Product Name -->
            <div class="form-group relative">
                <div class="input-container">
                    <input type="text" name="name" id="name" required
                           class="enhanced-input peer"
                           placeholder=" ">
                    <div class="input-line"></div>
                    <label class="floating-label">Product Name *</label>
                </div>
                @error('name')
                <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <!-- SKU -->
            <div class="form-group relative">
                <div class="input-container">
                    <input type="text" name="sku" id="sku" required
                           class="enhanced-input peer"
                           placeholder=" ">
                    <div class="input-line"></div>
                    <label class="floating-label">SKU *</label>
                </div>
                @error('sku')
                <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <!-- Price & Quantity -->
            <div class="grid grid-cols-2 gap-6">
                <div class="form-group relative">
                    <div class="input-container">
                        <input type="number" name="price" id="price" min="0" step="0.01" required
                               class="enhanced-input peer"
                               placeholder=" ">
                        <div class="input-line"></div>
                        <label class="floating-label">Price *</label>
                    </div>
                    @error('price')
                    <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group relative">
                    <div class="input-container">
                        <input type="number" name="quantity" id="quantity" min="0" required
                               class="enhanced-input peer"
                               placeholder=" ">
                        <div class="input-line"></div>
                        <label class="floating-label">Quantity *</label>
                    </div>
                    @error('quantity')
                    <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Description -->
            <div class="form-group relative">
                <div class="input-container">
                <textarea name="description" id="description" rows="3"
                          class="enhanced-input peer pt-4"
                          placeholder=" "></textarea>
                    <div class="input-line"></div>
                    <label class="floating-label">Description</label>
                </div>
            </div>

            <!-- Supplier -->
            <div class="form-group relative">
                <div class="input-container">
                    <select name="supplier_id" id="supplier_id"
                            class="enhanced-input peer">
                        <option value="">-- No Supplier --</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                {{ $supplier->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="input-line"></div>
                    <label class="floating-label">Supplier</label>
                </div>
                @error('supplier_id')
                <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex justify-between gap-4">
                <a href="{{ route('dashboard') }}"
                   class="flex-1 text-center border border-cyan-500/30 text-cyan-300 py-3 px-6 rounded-lg
                      hover:bg-cyan-900/20 transition-all duration-300">
                    Cancel
                </a>
                <button type="submit"
                        class="flex-1 bg-gradient-to-r from-green-500 to-cyan-600 text-white py-3 px-6 rounded-lg
                           transition-all duration-300 hover:shadow-xl hover:shadow-green-500/20
                           hover:-translate-y-0.5">
                    Save Product
                </button>
            </div>
        </form>
    </div>

    <style>
        .glass-container {
            background: rgba(16, 24, 39, 0.9); /* Darker background */
        }

        .input-container {
            position: relative;
            margin-bottom: 2rem;
        }

        .enhanced-input {
            @apply w-full px-4 py-3 bg-white/10 backdrop-blur-sm
            border-b-2 border-cyan-500/50 rounded-t-lg
            text-white placeholder-transparent
            transition-all duration-200;
            background: rgba(255, 255, 255, 0.1); /* Solid dark background */
        }

        .enhanced-input:focus {
            @apply border-cyan-400;
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 10px 15px -5px rgba(6, 182, 212, 0.2);
        }

        /* Select dropdown styling */
        select.enhanced-input {
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23ffffff' stroke='%23ffffff' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        }

        select.enhanced-input option {
            background: rgba(16, 24, 39, 0.9); /* Dark background for options */
            color: white;
            padding: 10px;
        }

        .input-line {
            @apply absolute bottom-0 left-0 right-0 h-0.5 bg-cyan-500/50;
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .floating-label {
            @apply absolute left-4 -top-3.5 text-cyan-300 text-sm font-medium
            transition-all duration-200 pointer-events-none;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .error-message {
            @apply text-red-400 text-xs mt-2 ml-2 font-medium;
            position: relative;
            padding-left: 20px;
        }

        .error-message::before {
            content: '⚠ ';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
        }
    </style>
@endsection
