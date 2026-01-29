<!DOCTYPE html>
<html>
<head>
    <title>Bus Ticket</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .header { border-bottom: 2px dashed #ccc; padding-bottom: 20px; margin-bottom: 20px; }
        .agency { font-size: 30px; font-weight: bold; color: #1e3a8a; text-transform: uppercase; }
        .route { font-size: 20px; margin-bottom: 20px; }
        .info-table { width: 100%; border-collapse: collapse; }
        .info-table td { padding: 10px; border: 1px solid #eee; }
        .label { font-size: 10px; color: #888; text-transform: uppercase; display: block; }
        .value { font-size: 14px; font-weight: bold; }
        .qr-box { text-align: center; margin-top: 30px; }
        .seat { font-size: 40px; font-weight: bold; color: #2563eb; }
    </style>
</head>
<body>
    <div class="header">
        <div class="agency">{{ $ticket->seat->bus->agency->name }}</div>
        <div>Ticket Ref: {{ $ticket->ticket_number }}</div>
    </div>

    <div class="route">
        {{ $ticket->booking->trip->route->origin }}
        &rarr;
        {{ $ticket->booking->trip->route->destination }}
    </div>

    <table class="info-table">
        <tr>
            <td>
                <span class="label">Passenger</span>
                <span class="value">{{ $ticket->passenger_name }}</span>
            </td>
            <td>
                <span class="label">Date</span>
                <span class="value">{{ $ticket->booking->trip->travel_date->format('d M Y') }}</span>
            </td>
            <td>
                <span class="label">Time</span>
                <span class="value">{{ \Carbon\Carbon::parse($ticket->booking->trip->departure_time)->format('H:i') }}</span>
            </td>
        </tr>
    </table>

    <div class="qr-box">
        <div class="seat">Seat {{ $ticket->seat->seat_number }}</div>
        <!-- Embed Base64 QR Code -->
        <img src="data:image/svg+xml;base64,{{ $qrCode }}" width="150" />
        <br>
        <small>Scan at check-in</small>
    </div>
</body>
</html>
