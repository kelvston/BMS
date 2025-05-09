@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="glass p-8 mx-auto max-w-md" style="transform-style: preserve-3d;">
    <h1 class="text-3xl font-bold mb-6 text-white text-center">Welcome Back</h1>

    <form action="{{ route('login') }}" method="POST" class="space-y-6">
        @csrf

        <div class="space-y-2">
            <label for="email" class="block text-cyan-100">Email Address</label>
            <input type="email" name="email" id="email"
                class="w-full px-4 py-3 bg-white/10 backdrop-blur-sm border border-cyan-500/30 rounded-lg focus:ring-2 focus:ring-cyan-300 focus:border-transparent text-white placeholder-cyan-200"
                placeholder="your@email.com" required autofocus>
            @error('email')
            <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2">
            <label for="password" class="block text-cyan-100">Password</label>
            <input type="password" name="password" id="password"
                class="w-full px-4 py-3 bg-white/10 backdrop-blur-sm border border-cyan-500/30 rounded-lg focus:ring-2 focus:ring-cyan-300 focus:border-transparent text-white placeholder-cyan-200"
                placeholder="••••••••" required>
            @error('password')
            <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input id="remember" name="remember" type="checkbox"
                    class="h-4 w-4 text-cyan-600 focus:ring-cyan-500 border-gray-300 rounded">
                <label for="remember" class="ml-2 block text-sm text-cyan-100">
                    Remember me
                </label>
            </div>
            @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="text-sm text-cyan-300 hover:text-cyan-100">
                Forgot password?
            </a>
            @endif
        </div>

        <button type="submit"
            class="w-full glow-btn py-3 px-4 rounded-lg text-lg font-medium transition-all duration-300">
            Sign In
        </button>
    </form>

    @if (Route::has('register'))
    <div class="mt-6 text-center">
        <p class="text-cyan-200">Don't have an account?
            <a href="{{ route('register') }}" class="text-cyan-100 font-medium hover:text-white">
                Register here
            </a>
        </p>
    </div>
    @endif
</div>
@endsection