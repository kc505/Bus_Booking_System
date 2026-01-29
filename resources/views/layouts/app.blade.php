<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'BusCam') }} - @yield('title', 'Bus Booking System')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@600;700;800&display=swap"
        rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="antialiased bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-700 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                            </svg>
                        </div>
                        <span class="text-xl font-display font-bold text-dark-800">BusCam</span>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('agencies.index') }}"
                        class="text-dark-600 hover:text-primary-600 font-medium transition-colors">
                        Book Ticket
                    </a>
                    <a href="{{ route('about') }}"
                        class="text-dark-600 hover:text-primary-600 font-medium transition-colors">
                        About
                    </a>
                    <a href="{{ route('contact') }}"
                        class="text-dark-600 hover:text-primary-600 font-medium transition-colors">
                        Contact
                    </a>
                </div>

                <!-- User Auth Section -->
                <div class="flex items-center space-x-4" x-data="{ mobileMenuOpen: false }">
                    @auth
                        <!-- User Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-3 focus:outline-none">
                                <div
                                    class="w-10 h-10 bg-primary-600 rounded-full flex items-center justify-center text-white font-bold">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <span class="hidden sm:inline font-semibold text-dark-900">{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4 text-dark-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="open" @click.away="open = false"
                                class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50" x-transition
                                style="display: none;">

                                @if (Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="block px-4 py-2 text-dark-700 hover:bg-gray-100">
                                        <i class="bi bi-speedometer2 me-2"></i>Dashboard
                                    </a>
                                @elseif(Auth::user()->role === 'staff')
                                    <!-- CONDUCTOR ONLY SEES CHECK-IN -->
                                    <a href="{{ route('admin.checkin') }}"
                                        class="block px-4 py-2 text-dark-700 hover:bg-gray-100 font-bold">
                                        <i class="bi bi-check2-circle me-2"></i>Passenger Check-in
                                    </a>
                                @else
                                    <!-- CUSTOMER VIEW -->
                                    <a href="{{ route('dashboard') }}"
                                        class="block px-4 py-2 text-dark-700 hover:bg-gray-100">
                                        <i class="bi bi-house me-2"></i>Dashboard
                                    </a>
                                    <a href="{{ route('bookings.index') }}"
                                        class="block px-4 py-2 text-dark-700 hover:bg-gray-100">
                                        <i class="bi bi-ticket me-2"></i>My Bookings
                                    </a>
                                @endif

                                <a href="{{ route('profile.edit') }}"
                                    class="block px-4 py-2 text-dark-700 hover:bg-gray-100">
                                    <i class="bi bi-person me-2"></i>Profile
                                </a>

                                <hr class="my-2">

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 font-bold">
                                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <!-- Guest Links -->
                        <a href="{{ route('login') }}"
                            class="text-dark-700 hover:text-primary-600 font-medium transition-colors">
                            Login
                        </a>
                        <a href="{{ route('register') }}"
                            class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2 rounded-lg font-medium transition-all transform hover:scale-105">
                            Sign Up
                        </a>
                    @endauth

                    <!-- Mobile menu button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="md:hidden text-dark-700 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div x-show="mobileMenuOpen" x-transition class="md:hidden bg-white border-t border-dark-200"
            style="display: none;">
            <div class="px-4 py-4 space-y-3">
                <a href="{{ route('agencies.index') }}"
                    class="block text-dark-600 hover:text-primary-600 font-medium">Book Ticket</a>
                <a href="{{ route('about') }}" class="block text-dark-600 hover:text-primary-600 font-medium">About</a>
                <a href="{{ route('contact') }}"
                    class="block text-dark-600 hover:text-primary-600 font-medium">Contact</a>
            </div>
        </div>

        <!-- Flash Messages -->
        @if (session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div
                    class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ session('success') }}
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div
                    class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ session('error') }}
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-800">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        <!-- Main Content -->
        <main>
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-dark-900 text-white mt-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid md:grid-cols-4 gap-8">
                    <div>
                        <div class="flex items-center space-x-2 mb-4">
                            <div
                                class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-700 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                </svg>
                            </div>
                            <span class="text-xl font-display font-bold">BusCam</span>
                        </div>
                        <p class="text-gray-400">Making bus travel in Cameroon easier, safer, and more convenient.</p>
                    </div>

                    <div>
                        <h3 class="font-display font-bold mb-4">Quick Links</h3>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="{{ route('agencies.index') }}"
                                    class="hover:text-primary-400 transition-colors">Book Ticket</a></li>
                            <li><a href="{{ route('about') }}" class="hover:text-primary-400 transition-colors">About
                                    Us</a></li>
                            <li><a href="{{ route('contact') }}"
                                    class="hover:text-primary-400 transition-colors">Contact</a></li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="font-display font-bold mb-4">Support</h3>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="#" class="hover:text-primary-400 transition-colors">Help Center</a>
                            </li>
                            <li><a href="#" class="hover:text-primary-400 transition-colors">Terms of
                                    Service</a></li>
                            <li><a href="#" class="hover:text-primary-400 transition-colors">Privacy Policy</a>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="font-display font-bold mb-4">Contact</h3>
                        <ul class="space-y-2 text-gray-400">
                            <li>Email: info@buscam.cm</li>
                            <li>Phone: +237 XXX XXX XXX</li>
                            <li>Yaoundé, Cameroon</li>
                        </ul>
                    </div>
                </div>

                <div class="border-t border-dark-700 mt-8 pt-8 text-center text-gray-400">
                    <p>&copy; {{ date('Y') }} BusCam. All rights reserved.</p>
                </div>
            </div>
        </footer>

        <!-- Alpine.js for dropdowns -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        @stack('scripts')
</body>

</html>
