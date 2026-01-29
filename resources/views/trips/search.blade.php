<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Trips</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-100 min-h-screen">
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-4 px-6 flex justify-between items-center">
            <h1 class="text-xl font-bold text-gray-800">Bus Booking</h1>
            <div class="flex items-center">
                <!-- Link back to Dashboard -->
                <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-900 font-semibold px-4 py-2 border border-transparent rounded-md hover:bg-gray-100 transition ease-in-out duration-150">
                  &larr; Back to Dashboard
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto py-8 px-6">
        <h2 class="text-2xl font-bold mb-6">Search Available Trips</h2>
        <livewire:trip-search />
    </main>

    @livewireScripts
</body>
</html>
