<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BusCam - Book Your Bus Ticket Online in Cameroon</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        html {
            scroll-behavior: smooth;
        }
        .section-spacing {
            padding-top: 5rem;
            padding-bottom: 5rem;
        }
        @media (min-width: 768px) {
            .section-spacing {
                padding-top: 7rem;
                padding-bottom: 7rem;
            }
        }
        h1, h2, h3 {
            font-family: 'Poppins', sans-serif;
        }
        .animate-fade-in {
            animation: fadeIn 0.6s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="antialiased bg-white text-gray-900">
    <!-- Navigation -->
    <nav class="fixed w-full bg-white/95 backdrop-blur-md shadow-sm z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="/" class="flex items-center space-x-2 hover:opacity-80 transition-opacity">
                    <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center hover:bg-blue-700 transition-colors">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-gray-900">BusCam</span>
                </a>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-gray-600 hover:text-blue-600 font-medium transition-colors duration-200">Features</a>
                    <a href="#agencies" class="text-gray-600 hover:text-blue-600 font-medium transition-colors duration-200">Agencies</a>
                    <a href="#how-it-works" class="text-gray-600 hover:text-blue-600 font-medium transition-colors duration-200">How It Works</a>
                    <a href="#contact" class="text-gray-600 hover:text-blue-600 font-medium transition-colors duration-200">Contact</a>
                </div>

                <div class="flex items-center space-x-4">
                    @guest
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 font-semibold transition-colors duration-200">Login</a>
                        <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition-all duration-200 hover:shadow-lg transform hover:-translate-y-0.5">Sign Up</a>
                    @else
                        <a href="{{ route('dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition-all duration-200 hover:shadow-lg">Dashboard</a>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-32 pb-16 px-4 sm:px-6 lg:px-8 bg-gradient-to-br from-blue-50 to-white">
        <div class="max-w-7xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="animate-fade-in">
                    <div class="inline-block bg-blue-100 text-blue-700 px-4 py-1.5 rounded-full text-sm font-semibold mb-6">
                        🚌 Trusted by 10,000+ Passengers
                    </div>
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 leading-tight mb-6">
                        Travel Across <span class="text-blue-600">Cameroon</span> with Ease
                    </h1>
                    <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                        Book your bus tickets online in seconds. Choose from multiple trusted agencies, select your seat, and travel comfortably.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold transition-all duration-200 hover:shadow-lg transform hover:-translate-y-0.5">
                            Book Your Ticket Now
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </a>
                        <a href="#how-it-works" class="inline-flex items-center justify-center bg-white border-2 border-gray-200 text-gray-800 px-8 py-3 rounded-lg font-semibold hover:bg-gray-50 hover:border-blue-300 transition-all duration-200 hover:shadow-md">
                            Learn More
                        </a>
                    </div>
                </div>
                <div class="relative animate-fade-in">
                    <div class="aspect-video rounded-2xl shadow-2xl overflow-hidden">
                        <img src="{{ asset('images/hero-bus.png') }}" alt="Bus Travel" class="w-full h-full object-cover" onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-full h-full bg-gradient-to-br from-blue-600 to-blue-400 flex items-center justify-center\'><svg class=\'w-32 h-32 text-white opacity-90\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1.5\' d=\'M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4\'/></svg></div>';">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-12 px-4 sm:px-6 lg:px-8 bg-white border-y border-gray-100">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div class="transform hover:scale-105 transition-transform duration-200">
                    <div class="text-4xl font-bold text-blue-600 mb-2">15+</div>
                    <div class="text-gray-600 font-medium">Bus Agencies</div>
                </div>
                <div class="transform hover:scale-105 transition-transform duration-200">
                    <div class="text-4xl font-bold text-blue-600 mb-2">50+</div>
                    <div class="text-gray-600 font-medium">Daily Routes</div>
                </div>
                <div class="transform hover:scale-105 transition-transform duration-200">
                    <div class="text-4xl font-bold text-blue-600 mb-2">99%</div>
                    <div class="text-gray-600 font-medium">On-Time Rate</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="section-spacing px-4 sm:px-6 lg:px-8 bg-gray-50">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">Why Choose BusCam?</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Experience hassle-free bus travel with our modern booking platform
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-xl border border-gray-200 hover:shadow-xl hover:border-blue-300 transition-all duration-300 transform hover:-translate-y-1">
                    <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Real-Time Availability</h3>
                    <p class="text-gray-600 leading-relaxed">
                        See live seat availability and book instantly. No more waiting in queues.
                    </p>
                </div>

                <div class="bg-white p-8 rounded-xl border border-gray-200 hover:shadow-xl hover:border-green-300 transition-all duration-300 transform hover:-translate-y-1">
                    <div class="w-14 h-14 bg-green-100 text-green-600 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Secure Payment</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Pay safely with MTN MoMo or Orange Money. All transactions are encrypted.
                    </p>
                </div>

                <div class="bg-white p-8 rounded-xl border border-gray-200 hover:shadow-xl hover:border-orange-300 transition-all duration-300 transform hover:-translate-y-1">
                    <div class="w-14 h-14 bg-orange-100 text-orange-600 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Digital E-Ticket</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Get your ticket with QR code instantly. Just scan and board the bus.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Agencies Section -->
    <section id="agencies" class="section-spacing px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">Trusted Partner Agencies</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    We work with the most reliable transport providers in Cameroon
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white border-2 border-gray-200 rounded-2xl p-8 text-center hover:border-blue-600 hover:shadow-xl transition-all duration-300 group transform hover:-translate-y-2">
                    <div class="w-20 h-20 bg-blue-600 text-white rounded-2xl flex items-center justify-center mx-auto mb-6 text-2xl font-bold group-hover:scale-110 group-hover:bg-blue-700 transition-all duration-300">
                        M
                    </div>
                    <h3 class="text-2xl font-bold mb-3 group-hover:text-blue-600 transition-colors">Musango</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Premium inter-city travel with modern comfortable buses
                    </p>
                    <a href="{{ route('register') }}" class="inline-flex items-center text-blue-600 font-semibold hover:underline group-hover:text-blue-700 transition-colors">
                        View Routes
                        <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>

                <div class="bg-white border-2 border-gray-200 rounded-2xl p-8 text-center hover:border-green-600 hover:shadow-xl transition-all duration-300 group transform hover:-translate-y-2">
                    <div class="w-20 h-20 bg-green-600 text-white rounded-2xl flex items-center justify-center mx-auto mb-6 text-2xl font-bold group-hover:scale-110 group-hover:bg-green-700 transition-all duration-300">
                        N
                    </div>
                    <h3 class="text-2xl font-bold mb-3 group-hover:text-green-600 transition-colors">Nso Boys</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Reliable service connecting North West to the rest of Cameroon
                    </p>
                    <a href="{{ route('register') }}" class="inline-flex items-center text-green-600 font-semibold hover:underline group-hover:text-green-700 transition-colors">
                        View Routes
                        <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>

                <div class="bg-white border-2 border-gray-200 rounded-2xl p-8 text-center hover:border-gray-800 hover:shadow-xl transition-all duration-300 group transform hover:-translate-y-2">
                    <div class="w-20 h-20 bg-gray-800 text-white rounded-2xl flex items-center justify-center mx-auto mb-6 text-2xl font-bold group-hover:scale-110 group-hover:bg-gray-900 transition-all duration-300">
                        P
                    </div>
                    <h3 class="text-2xl font-bold mb-3 group-hover:text-gray-800 transition-colors">Park Lane</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Executive bus services across major cities in Cameroon
                    </p>
                    <a href="{{ route('register') }}" class="inline-flex items-center text-gray-800 font-semibold hover:underline group-hover:text-gray-900 transition-colors">
                        View Routes
                        <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="section-spacing px-4 sm:px-6 lg:px-8 bg-gray-50">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">How It Works</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Book your bus ticket in just 3 simple steps
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-12">
                <div class="text-center group">
                    <div class="w-16 h-16 bg-blue-600 text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-6 group-hover:bg-blue-700 group-hover:scale-110 transition-all duration-300 shadow-lg">
                        1
                    </div>
                    <h3 class="text-xl font-bold mb-3">Choose Your Route</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Select departure city, destination, and travel date
                    </p>
                </div>

                <div class="text-center group">
                    <div class="w-16 h-16 bg-blue-600 text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-6 group-hover:bg-blue-700 group-hover:scale-110 transition-all duration-300 shadow-lg">
                        2
                    </div>
                    <h3 class="text-xl font-bold mb-3">Select Your Seat</h3>
                    <p class="text-gray-600 leading-relaxed">
                        View bus layout and pick your preferred seat
                    </p>
                </div>

                <div class="text-center group">
                    <div class="w-16 h-16 bg-blue-600 text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-6 group-hover:bg-blue-700 group-hover:scale-110 transition-all duration-300 shadow-lg">
                        3
                    </div>
                    <h3 class="text-xl font-bold mb-3">Pay & Board</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Pay via MoMo and receive your QR code ticket
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 px-4 sm:px-6 lg:px-8 bg-gradient-to-r from-blue-600 to-blue-700">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl sm:text-4xl font-bold text-white mb-6">
                Ready to Start Your Journey?
            </h2>
            <p class="text-lg text-blue-100 mb-8">
                Join thousands of passengers traveling across Cameroon safely
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" class="inline-flex items-center justify-center bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-all duration-200 hover:shadow-xl transform hover:-translate-y-0.5">
                    Book Your First Ticket
                </a>
                <a href="#contact" class="inline-flex items-center justify-center bg-transparent border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white/10 transition-all duration-200 hover:shadow-xl">
                    Contact Us
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact" class="bg-gray-900 text-white py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-4 gap-12 mb-12">
                <div>
                    <h2 class="text-2xl font-bold mb-4">BusCam</h2>
                    <p class="text-gray-400 leading-relaxed">
                        Making bus travel in Cameroon easier and more convenient.
                    </p>
                </div>
                <div>
                    <h3 class="font-bold mb-4">Quick Links</h3>
                    <ul class="space-y-3 text-gray-400">
                        <li><a href="#features" class="hover:text-white transition-colors duration-200">Features</a></li>
                        <li><a href="#agencies" class="hover:text-white transition-colors duration-200">Agencies</a></li>
                        <li><a href="#how-it-works" class="hover:text-white transition-colors duration-200">How It Works</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-bold mb-4">Legal</h3>
                    <ul class="space-y-3 text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors duration-200">Terms of Service</a></li>
                        <li><a href="#" class="hover:text-white transition-colors duration-200">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-white transition-colors duration-200">Refund Policy</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-bold mb-4">Contact</h3>
                    <ul class="space-y-3 text-gray-400">
                        <li class="hover:text-white transition-colors">support@buscam.cm</li>
                        <li class="hover:text-white transition-colors">+237 600 000 000</li>
                        <li class="hover:text-white transition-colors">Yaoundé, Cameroon</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-gray-500 text-sm">
                &copy; {{ date('Y') }} BusCam. All rights reserved.
            </div>
        </div>
    </footer>
</body>
</html>
