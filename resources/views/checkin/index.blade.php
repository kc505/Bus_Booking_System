<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Staff Check-in Scanner') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="text-center mb-8">
                    <h3 class="text-2xl font-bold text-gray-700">Scan QR Code</h3>
                    <p class="text-gray-500">Enter ticket number or use scanner</p>
                </div>

                <!-- ALERTS -->
                @if(session('success'))
                    <div class="bg-green-100 border-l-8 border-green-500 text-green-700 p-6 mb-4 rounded shadow-lg text-center">
                        <p class="text-3xl font-bold">✅ APPROVED</p>
                        <p class="text-xl mt-2">{{ session('success') }}</p>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border-l-8 border-red-500 text-red-700 p-6 mb-4 rounded shadow-lg text-center">
                        <p class="text-3xl font-bold">❌ DENIED</p>
                        <p class="text-xl mt-2">{{ session('error') }}</p>
                    </div>
                @endif

                <!-- FORM -->
                <form action="{{ route('checkin.verify') }}" method="POST" class="mt-6">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Ticket Number</label>
                        <input type="text"
                               name="ticket_number"
                               class="shadow appearance-none border rounded w-full py-4 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline text-2xl font-mono text-center uppercase"
                               placeholder="TKT..."
                               autofocus
                               required>
                    </div>

                    <button type="submit" class="w-full bg-blue-800 hover:bg-blue-900 text-white font-bold py-4 px-4 rounded focus:outline-none focus:shadow-outline text-xl">
                        Verify Ticket
                    </button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
