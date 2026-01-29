<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;

class TicketController extends Controller
{
    public function show($id)
    {
        // Find the ticket and load all relationships
        $ticket = Ticket::with(['booking.user', 'seat.bus.agency', 'seat.bus', 'booking.trip.route'])
            ->findOrFail($id);

        // Security Check: Ensure the logged-in user owns this ticket
        if ($ticket->booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Generate QR Code
        // We embed the Ticket Number. Later the admin scanner will read this.
        $qrCode = QrCode::size(200)->generate($ticket->ticket_number);

        return view('tickets.show', compact('ticket', 'qrCode'));
    }

     public function download($id)
{
    $ticket = Ticket::with(['booking.user', 'seat.bus.agency', 'booking.trip.route'])
        ->findOrFail($id);

    // Security Check
    if ($ticket->booking->user_id !== auth()->id()) {
        abort(403);
    }

    // Generate QR Code as Base64 image (Required for PDF)
    $qrCode = base64_encode(QrCode::format('svg')->size(150)->generate($ticket->ticket_number));

    // Load a special PDF view
    $pdf = Pdf::loadView('tickets.pdf', compact('ticket', 'qrCode'));

    return $pdf->download('ticket-'.$ticket->ticket_number.'.pdf');
}
}
