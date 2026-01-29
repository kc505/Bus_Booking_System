<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Agencies Table
        if (!Schema::hasTable('agencies')) {
            Schema::create('agencies', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->text('description')->nullable();
                $table->string('logo')->nullable();
                $table->decimal('rating', 3, 2)->default(4.5);
                $table->string('phone')->nullable();
                $table->string('email')->nullable();
                $table->integer('total_buses')->default(0);
                $table->timestamps();
                $table->softDeletes();
            });
        }

        // Cities Table (if not exists)
        if (!Schema::hasTable('cities')) {
            Schema::create('cities', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('region')->nullable();
                $table->timestamps();
            });
        }





        // Bookings Table (Multi-Agency System)
        // This is separate from your existing bookings table
        if (!Schema::hasTable('multi_agency_bookings')) {
           Schema::create('multi_agency_bookings', function (Blueprint $table) {
    $table->id();
    $table->string('booking_number')->unique();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('agency_id')->constrained()->onDelete('cascade');
    $table->foreignId('route_id')->constrained('routes')->onDelete('cascade');
    $table->string('passenger_name');
    $table->string('passenger_phone');
    $table->string('passenger_email');
    $table->string('origin');
    $table->string('destination');
    $table->date('travel_date');
    $table->time('departure_time');
    $table->json('seats');
    $table->decimal('total_amount', 10, 2);
    $table->string('payment_method')->nullable();
    $table->string('payment_status')->default('pending');
    $table->string('payment_reference')->nullable();
    $table->string('status')->default('pending');
    $table->decimal('refund_amount', 10, 2)->nullable();
    $table->string('refund_status')->nullable();
    $table->timestamp('checked_in_at')->nullable();
    $table->timestamp('no_show_at')->nullable();
    $table->timestamp('cancelled_at')->nullable();
    $table->timestamps();
    $table->softDeletes();
});
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('multi_agency_bookings');
        Schema::dropIfExists('bus_routes');
        Schema::dropIfExists('agencies');
        // Don't drop cities as it might be used elsewhere
    }
};
