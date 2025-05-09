<nav class="bg-gray-900 bg-opacity-50 backdrop-filter backdrop-blur-lg border-b border-gray-800">
    <div class="container mx-auto px-4 py-3 flex justify-between items-center">
        <a href="{{ url('/') }}" class="flex items-center">
            <span class="logo-main text-2xl">BMS</span>
        </a>

        <div class="flex space-x-4">
            @guest
            <a href="{{ route('login') }}" class="text-white hover:text-primary px-3 py-2">Login</a>
            @if (Route::has('register'))
            <a href="{{ route('register') }}" class="text-white hover:text-primary px-3 py-2">Register</a>
            @endif
            @else
            <!-- Authenticated user links -->
            @endguest
        </div>
    </div>
</nav>