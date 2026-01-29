@extends('layouts.admin')

@section('page-title', 'Manage Routes')

@section('content')
<div class="p-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Manage Routes</h1>
        <a href="{{ route('admin.routes.create') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-semibold">
            + Add New Route
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-dark-700 uppercase">Agency</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-dark-700 uppercase">Route</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-dark-700 uppercase">Price</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-dark-700 uppercase">Duration</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-dark-700 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-dark-700 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-dark-200">
                @forelse($routes as $route)
                <tr>
                    <td class="px-6 py-4">{{ $route->agency->name ?? 'N/A' }}</td>
                    <td class="px-6 py-4">
                        <div class="font-semibold">{{ $route->origin }} → {{ $route->destination }}</div>
                    </td>
                    <td class="px-6 py-4">{{ number_format($route->base_price) }} FCFA</td>
                    <td class="px-6 py-4">{{ $route->estimated_duration_minutes }} mins</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded-full {{ $route->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $route->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.routes.edit', $route) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                            <form action="{{ route('admin.routes.destroy', $route) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-dark-500">No routes found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $routes->links() }}
    </div>
</div>
@endsection
