<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Route;
use App\Models\Agency;
use App\Models\City;
use Illuminate\Http\Request;

class RouteManagementController extends Controller
{
    public function index()
    {
        $routes = Route::with(['agency', 'departurecity', 'destinationcity'])
            ->paginate(15);
        return view('admin.routes.index', compact('routes'));
    }

    public function create()
    {
        $agencies = Agency::all();
        $cities = City::all();
        return view('admin.routes.create', compact('agencies', 'cities'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'agency_id' => 'required|exists:agencies,id',
            'origin' => 'required|string',
            'destination' => 'required|string',
            'base_price' => 'required|numeric|min:0',
            'estimated_duration_minutes' => 'required|integer|min:1',
        ]);

        $validated['is_active'] = true;

        Route::create($validated);

        return redirect()->route('admin.routes.index')
            ->with('success', 'Route created successfully!');
    }

    public function show(Route $route)
    {
        $route->load(['agency', 'departurecity', 'destinationcity']);
        return view('admin.routes.show', compact('route'));
    }

    public function edit(Route $route)
    {
        $agencies = Agency::all();
        $cities = City::all();
        return view('admin.routes.edit', compact('route', 'agencies', 'cities'));
    }

    public function update(Request $request, Route $route)
    {
        $validated = $request->validate([
            'agency_id' => 'required|exists:agencies,id',
            'origin' => 'required|string',
            'destination' => 'required|string',
            'base_price' => 'required|numeric|min:0',
            'estimated_duration_minutes' => 'required|integer|min:1',
            'is_active' => 'boolean',
        ]);

        $route->update($validated);

        return redirect()->route('admin.routes.index')
            ->with('success', 'Route updated successfully!');
    }

    public function destroy(Route $route)
    {
        $route->delete();
        return redirect()->route('admin.routes.index')
            ->with('success', 'Route deleted successfully!');
    }
}
