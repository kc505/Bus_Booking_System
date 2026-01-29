<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Book Your Seat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <h1 class="text-3xl font-bold text-red-600 mb-4">SYSTEM CHECK</h1>
                    <p class="mb-4">If you can see this text, the view is working!</p>

                    <!-- Simple Static Seat Grid -->
                    <div class="grid grid-cols-4 gap-4 bg-gray-100 p-4">
                        <div class="bg-blue-500 text-white p-4 rounded">Seat 1</div>
                        <div class="bg-white border p-4 rounded">Seat 2</div>
                        <div class="bg-white border p-4 rounded">Seat 3</div>
                        <div class="bg-white border p-4 rounded">Seat 4</div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
