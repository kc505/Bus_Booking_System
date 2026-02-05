<?php

namespace App\Http\Controllers\Passenger;

use App\Http\Controllers\Controller;
use App\Models\Dispute;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    $validated = $request->validate([
        'title'       => 'required|string|max:255',
        'description' => 'required|string|min:10',
        'booking_id'  => 'nullable|exists:bookings,id',
        'agency_id'   => 'required|exists:agencies,id',   // ← required now
    ]);

    Dispute::create([
        'user_id'     => Auth::id(),
        'booking_id'  => $request->booking_id,
        'agency_id'   => $validated['agency_id'],         // ← now passed
        'title'       => $validated['title'],
        'description' => $validated['description'],
        'status'      => 'pending',
    ]);

    return redirect()->route('disputes.index')
                     ->with('success', 'Your dispute has been submitted successfully. We will review it soon.');
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
