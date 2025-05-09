@extends('layouts.app')

@section('title', 'Add New Customer')

@section('content')
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="glass-form-container w-full max-w-md p-8 rounded-2xl shadow-xl">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-white mb-2">New Customer</h1>
                <div class="h-1 bg-cyan-400 w-20 mx-auto rounded-full"></div>
            </div>

            <form action="{{ route('customers.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Form Group -->
                <div class="form-group">
                    <div class="input-container">
                        <input type="text" name="name" id="name" required
                               class="form-input"
                               placeholder="Full Name">
                        <div class="input-border"></div>
                    </div>
                    @error('name')
                    <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Repeat for other fields -->
                <div class="form-group">
                    <div class="input-container">
                        <input type="email" name="email" id="email" required
                               class="form-input"
                               placeholder="Email Address">
                        <div class="input-border"></div>
                    </div>
                    @error('email')
                    <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="form-group">
                        <div class="input-container">
                            <input type="text" name="phone" id="phone" required
                                   class="form-input"
                                   placeholder="Phone Number">
                            <div class="input-border"></div>
                        </div>
                        @error('phone')
                        <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="input-container">
                            <input type="text" name="company_name" id="company_name"
                                   class="form-input"
                                   placeholder="Company (Optional)">
                            <div class="input-border"></div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-container">
                    <textarea name="address" id="address" rows="3"
                              class="form-input pt-4"
                              placeholder="Address (Optional)"></textarea>
                        <div class="input-border"></div>
                    </div>
                </div>

                <button type="submit"
                        class="w-full bg-gradient-to-r from-cyan-500 to-blue-600 text-white py-3 px-6 rounded-lg
                           transition-all duration-300 hover:shadow-xl hover:shadow-cyan-500/20
                           hover:-translate-y-0.5">
                    Create Customer
                </button>

                <div class="mt-6 text-center">
                    <a href="{{ route('customers.index') }}"
                       class="text-cyan-300 hover:text-white text-sm
                          transition-colors duration-200 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back to Customers
                    </a>
                </div>
            </form>
        </div>
    </div>

    <style>
        .glass-form-container {
            background: rgba(16, 24, 39, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .form-input {
            @apply w-full px-4 py-3 bg-white/5 rounded-lg
            text-white placeholder-gray-400
            transition-all duration-200
            focus:outline-none focus:bg-white/10;
        }

        .input-container {
            position: relative;
        }

        .input-border {
            @apply absolute inset-0 rounded-lg pointer-events-none;
            border: 1px solid rgba(6, 182, 212, 0.3);
            transition: all 0.3s ease;
        }

        .form-input:focus ~ .input-border {
            border: 1px solid rgba(6, 182, 212, 0.6);
            box-shadow: 0 0 15px rgba(6, 182, 212, 0.2);
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
