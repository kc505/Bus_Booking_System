<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Search Bus Tickets') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-6">Find Your Bus</h3>

                    <form action="{{ route('search.submit') }}" method="POST" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">From</label>
                                <select name="origin" class="w-full border border-gray-300 rounded-md p-3" required>
                                    <option value="">Select departure city</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city }}">{{ $city }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">To</label>
                                <select name="destination" class="w-full border border-gray-300 rounded-md p-3" required>
                                    <option value="">Select arrival city</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city }}">{{ $city }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Travel Date</label>
                                <input type="date" name="travel_date"
                                       class="w-full border border-gray-300 rounded-md p-3"
                                       min="{{ now()->format('Y-m-d') }}"
                                       value="{{ now()->format('Y-m-d') }}"
                                       required>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit"
                                    class="bg-blue-600 text-white px-8 py-3 rounded-md hover:bg-blue-700 font-semibold">
                                Search Buses
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
