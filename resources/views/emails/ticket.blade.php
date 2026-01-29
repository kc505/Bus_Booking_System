<x-mail::message>
# Booking Confirmed!

Hello {{ $ticket->passenger_name }},

Your payment was successful. We have attached your official ticket to this email.

**Trip Details:**
* **From:** {{ $ticket->booking->trip->route->origin }}
* **To:** {{ $ticket->booking->trip->route->destination }}
* **Date:** {{ $ticket->booking->trip->travel_date->format('d M Y') }}
* **Seat:** {{ $ticket->seat->seat_number }}

Please arrive 30 minutes before departure.

<x-mail::button :url="route('tickets.show', $ticket->id)">
View Digital Ticket
</x-mail::button>

Safe Travels,<br>
{{ config('app.name') }}
</x-mail::message>
