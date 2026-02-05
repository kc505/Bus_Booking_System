<?php

namespace App\Http\Controllers\Passenger;

use App\Http\Controllers\Controller;
use App\Models\Dispute;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DisputeController extends Controller
{
    public function create()
    {

    $bookings = Auth::user()->bookings()->latest()->take(10)->get();
    $agencies = \App\Models\Agency::where('status', 'active')->get(['id', 'name']); // only active agencies

       return view('passenger.disputes.create', compact('bookings', 'agencies'));
    }

    public function store(Request $request)
{
    try {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'agency_id'   => 'required|exists:agencies,id',
            'description' => 'required|string|min:10',
            'booking_id'  => 'nullable|exists:bookings,id',
        ]);

        $dispute = Dispute::create([
            'user_id'     => Auth::id(),
            'agency_id'   => $validated['agency_id'],
            'booking_id'  => $request->booking_id,
            'title'       => $validated['title'],
            'description' => $validated['description'],
            'status'      => 'pending',
        ]);

        // Debug: log what was saved
        Log::info('Dispute created', $dispute->toArray());

        return redirect()->route('disputes.index')
                         ->with('success', 'Your dispute has been submitted successfully. We will review it soon.');
    } catch (\Exception $e) {
        // Catch and show any error
        Log::error('Dispute creation failed: ' . $e->getMessage());
        return back()->withErrors(['error' => $e->getMessage()])->withInput();
    }
}

    public function index()
    {
        $disputes = Dispute::where('user_id', auth()->id())
            ->with(['agency', 'booking'])
            ->latest()
            ->paginate(10);

        return view('passenger.disputes.index', compact('disputes'));
    }

    public function show(Dispute $dispute)
    {
        // Ensure the dispute belongs to the authenticated user
        if ($dispute->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this dispute.');
        }

        $dispute->load(['agency', 'booking', 'resolver']);

        return view('passenger.disputes.show', compact('dispute'));
    }
}
