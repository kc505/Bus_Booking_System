<?php

namespace App\Http\Controllers\Passenger;

use App\Http\Controllers\Controller;
use App\Models\Dispute;
use App\Models\Booking;
use Illuminate\Http\Request;

class DisputeController extends Controller
{
    public function create()
    {
        $bookings = Booking::where('user_id', auth()->id())
            ->with('agency')
            ->latest()
            ->get();

        return view('passenger.disputes.create', compact('bookings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => 'nullable|exists:multi_agency_bookings,id',
            'agency_id' => 'required|exists:agencies,id',
            'subject' => 'required|string|max:255',
            'description' => 'required|string|min:20',
            'priority' => 'required|in:low,medium,high,urgent',
        ]);

        Dispute::create([
            'user_id' => auth()->id(),
            'agency_id' => $request->agency_id,
            'booking_id' => $request->booking_id,
            'subject' => $request->subject,
            'description' => $request->description,
            'priority' => $request->priority,
            'status' => 'pending',
        ]);

        return redirect()->route('dashboard')->with('success', 'Dispute submitted successfully. We will review it soon.');
    }

    public function index()
    {
        $disputes = Dispute::where('user_id', auth()->id())
            ->with(['agency', 'booking'])
            ->latest()
            ->paginate(10);

        return view('passenger.disputes.index', compact('disputes'));
    }
}
