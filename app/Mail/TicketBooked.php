<?php

namespace App\Mail;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TicketBooked extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;

    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Bus Ticket - ' . $this->ticket->ticket_number,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.ticket',
        );
    }

    // Attach the PDF automatically
    public function attachments(): array
    {
        // Generate QR for PDF
        $qrCode = base64_encode(QrCode::format('svg')->size(150)->generate($this->ticket->ticket_number));

        // Generate PDF in memory
        $pdf = Pdf::loadView('tickets.pdf', [
            'ticket' => $this->ticket,
            'qrCode' => $qrCode
        ]);

        return [
            \Illuminate\Mail\Mailables\Attachment::fromData(fn () => $pdf->output(), 'Ticket.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
