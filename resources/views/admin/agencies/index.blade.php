@extends('layouts.admin')

@section('page-title', 'Manage Agencies')

@section('content')
<div class="p-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Manage Agencies</h1>
        <a href="{{ route('admin.agencies.create') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-semibold">
            + Add New Agency
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-dark-700 uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-dark-700 uppercase">Routes</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-dark-700 uppercase">Contact</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-dark-700 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-dark-200">
                @forelse($agencies as $agency)
                <tr>
                    <td class="px-6 py-4">
                        <div class="font-semibold">{{ $agency->name }}</div>
                        <div class="text-sm text-dark-500">{{ Str::limit($agency->description, 50) }}</div>
                    </td>
                    <td class="px-6 py-4">{{ $agency->routes_count }} routes</td>
                    <td class="px-6 py-4 text-sm">
                        <div>{{ $agency->phone }}</div>
                        <div class="text-dark-500">{{ $agency->email }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.agencies.edit', $agency) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                            <form action="{{ route('admin.agencies.destroy', $agency) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-dark-500">No agencies found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $agencies->links() }}
    </div>
</div>
@endsection
