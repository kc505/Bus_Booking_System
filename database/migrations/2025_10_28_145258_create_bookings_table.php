<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_number')->unique();

            // User & Agency
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('agency_id')->constrained()->onDelete('cascade');
            $table->foreignId('route_id')->constrained('routes')->onDelete('cascade');

            // Passenger Details
            $table->string('passenger_name');
            $table->string('passenger_phone');
            $table->string('passenger_email');

            // Trip Details
            $table->string('origin');
            $table->string('destination');
            $table->date('travel_date');
            $table->time('departure_time');
            $table->json('seats'); // Array of seat numbers

            // Payment
            $table->decimal('total_amount', 10, 2);
            $table->string('payment_method')->nullable();
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->default('pending');

            // Booking Status
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed', 'checked_in'])->default('pending');

            // Refund Info
            $table->decimal('refund_amount', 10, 2)->nullable();
            $table->string('refund_status')->nullable();
            $table->timestamp('cancelled_at')->nullable();

            $table->timestamps();

            // Indexes
            $table->index(['travel_date', 'departure_time']);
            $table->index('status');
            $table->index('payment_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
