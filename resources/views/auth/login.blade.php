<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BusCam</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <a href="{{ route('home') }}" class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-primary-600 rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                        </svg>
                    </div>
                    <span class="text-2xl font-display font-bold text-dark-900">BusCam</span>
                </a>
                <div class="flex items-center space-x-6">
                    <a href="{{ route('home') }}" class="text-dark-600 hover:text-primary-600 font-semibold">Home</a>
                    {{-- <a href="{{ route('agencies.index') }}" class="text-dark-600 hover:text-primary-600 font-semibold">Agencies</a> --}}
                    <a href="{{ route('register') }}" class="bg-primary-600 text-white px-6 py-2.5 rounded-lg font-semibold hover:bg-primary-700">Sign Up</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Login Form -->
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-display font-bold text-dark-900 mb-2">Welcome Back</h2>
                <p class="text-dark-600">Login to book your next trip</p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-xl p-8">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email -->
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-dark-700 mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="w-full px-4 py-3 border border-dark-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-dark-700 mb-2">Password</label>
                        <input type="password" name="password" required
                            class="w-full px-4 py-3 border border-dark-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('password') border-red-500 @enderror">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" name="remember" class="w-4 h-4 text-primary-600 border-dark-300 rounded focus:ring-primary-500">
                            <span class="ml-2 text-sm text-dark-600">Remember me</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-primary-600 hover:text-primary-700 font-semibold">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full bg-primary-600 text-white py-3 rounded-lg font-bold text-lg hover:bg-primary-700 transition-all">
                        Log In
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-dark-600">
                        Don't have an account?
                        <a href="{{ route('register') }}" class="text-primary-600 hover:text-primary-700 font-semibold">Sign up</a>
                    </p>
                </div>
            </div>

            <!-- Trust Badge -->
            <div class="mt-8 text-center">
                <p class="text-sm text-dark-500">🚌 Trusted by 10,000+ Passengers</p>
            </div>
        </div>
    </div>
</body>
</html>
