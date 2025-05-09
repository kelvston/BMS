@extends('layouts.app')

@section('title', 'Edit Customer')

@section('content')
    <div class="glass-container rounded-xl shadow-2xl p-8 mx-auto max-w-md backdrop-blur-lg border border-white/10">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold bg-gradient-to-r from-cyan-400 to-white bg-clip-text text-transparent">
                Edit Customer
            </h1>
            <div class="h-1 bg-cyan-400 w-20 mx-auto rounded-full mt-2"></div>
        </div>

        <form action="{{ route('customers.update', $customer) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="form-group relative">
                <input type="text" name="name" id="name"
                       value="{{ old('name', $customer->name) }}"
                       class="glass-input peer"
                       required>
                <div class="input-border"></div>
                <label class="floating-label">Full Name</label>

                @error('name')
                <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group relative">
                <input type="email" name="email" id="email"
                       value="{{ old('email', $customer->email) }}"
                       class="glass-input peer"
                       required>
                <div class="input-border"></div>
                <label class="floating-label">Email Address</label>

                @error('email')
                <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group relative">
                <input type="text" name="phone" id="phone"
                       value="{{ old('phone', $customer->phone) }}"
                       class="glass-input peer"
                       required>
                <div class="input-border"></div>
                <label class="floating-label">Phone Number</label>

                @error('phone')
                <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group relative">
                <input type="text" name="company_name" id="company_name"
                       value="{{ old('company_name', $customer->company_name) }}"
                       class="glass-input peer">
                <div class="input-border"></div>
                <label class="floating-label">Company (Optional)</label>

            </div>

            <div class="form-group relative">
            <textarea name="address" id="address" rows="3"
                      class="glass-input peer pt-4">{{ old('address', $customer->address) }}</textarea>
                <label class="floating-label">Address (Optional)</label>
                <div class="input-border"></div>
            </div>

            <div class="flex justify-between gap-4">
                <button type="submit"
                        class="flex-1 bg-gradient-to-r from-cyan-500 to-blue-600 text-white py-3 px-6 rounded-lg
                           transition-all duration-300 hover:shadow-xl hover:shadow-cyan-500/20
                           hover:-translate-y-0.5">
                    Update Customer
                </button>

                <a href="{{ route('customers.index') }}"
                   class="flex-1 text-center border border-cyan-500/30 text-cyan-300 py-3 px-6 rounded-lg
                      hover:bg-cyan-900/20 transition-all duration-300">
                    Cancel
                </a>
            </div>
        </form>
    </div>

    <style>
        .input-border {
            @apply absolute inset-0 rounded-lg pointer-events-none;
            border: 1px solid rgba(6, 182, 212, 0.3);
            transition: all 0.3s ease;
        }

        .form-input:focus ~ .input-border {
            border: 1px solid rgba(6, 182, 212, 0.6);
            box-shadow: 0 0 15px rgba(6, 182, 212, 0.2);
        }
        .glass-container {
            background: rgba(16, 24, 39, 0.6);
        }

        .form-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .glass-input {
            @apply w-full px-4 py-3 bg-white/10 backdrop-blur-sm
            border-2 border-cyan-500/40 rounded-lg
            text-white placeholder-transparent
            transition-all duration-200;
        }

        .glass-input:focus {
            @apply border-cyan-400 shadow-lg shadow-cyan-500/20;
            outline: none;
            background: rgba(255, 255, 255, 0.15);
        }

        .floating-label {
            @apply absolute left-4 -top-3.5 text-cyan-300 text-sm font-medium
            transition-all duration-200 pointer-events-none
            bg-gradient-to-r from-cyan-900/80 to-transparent px-2
            rounded-full;
        }

        .glass-input:placeholder-shown + .floating-label {
            @apply top-3.5 text-cyan-300/70 bg-cyan-900/30;
            transform: translateY(0);
        }

        .glass-input:focus + .floating-label {
            @apply text-cyan-200 -top-3.5 left-4 text-sm bg-cyan-900/50;
        }

        .error-message {
            @apply text-red-400 text-xs mt-2 ml-2 font-medium;
        }
    </style>
@endsection
