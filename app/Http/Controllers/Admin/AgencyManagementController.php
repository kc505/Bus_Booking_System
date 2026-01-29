<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use Illuminate\Http\Request;

class AgencyManagementController extends Controller
{
    public function index()
    {
        $agencies = Agency::withCount('routes')->paginate(10);
        return view('admin.agencies.index', compact('agencies'));
    }

    public function create()
    {
        return view('admin.agencies.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'logo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('agencies', 'public');
        }

        Agency::create($validated);

        return redirect()->route('admin.agencies.index')
            ->with('success', 'Agency created successfully!');
    }

    public function show(Agency $agency)
    {
        $agency->load('routes');
        return view('admin.agencies.show', compact('agency'));
    }

    public function edit(Agency $agency)
    {
        return view('admin.agencies.edit', compact('agency'));
    }

    public function update(Request $request, Agency $agency)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'logo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('agencies', 'public');
        }

        $agency->update($validated);

        return redirect()->route('admin.agencies.index')
            ->with('success', 'Agency updated successfully!');
    }

    public function destroy(Agency $agency)
    {
        $agency->delete();
        return redirect()->route('admin.agencies.index')
            ->with('success', 'Agency deleted successfully!');
    }
}
