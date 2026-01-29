<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use Carbon\Carbon;

class MarkNoShows extends Command
{
    protected $signature = 'bookings:mark-no-shows';
    protected $description = 'Mark bookings as no-show if not checked in after departure time';

    public function handle()
    {
        $now = Carbon::now();

        // Find bookings that:
        // 1. Are confirmed but not checked in
        // 2. Departure time has passed
        $noShows = Booking::where('status', 'confirmed')
            ->whereNull('checked_in_at')
            ->where(function($query) use ($now) {
                $query->whereRaw("CONCAT(travel_date, ' ', departure_time) < ?", [$now]);
            })
            ->update([
                'status' => 'no_show',
                'no_show_at' => $now
            ]);

        $this->info("Marked {$noShows} bookings as no-show");

        return 0;
    }
}
