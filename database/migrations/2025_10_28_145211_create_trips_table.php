<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bus_id')->constrained()->onDelete('cascade');
            $table->foreignId('route_id')->constrained()->onDelete('cascade');

            $table->date('travel_date');

            // This fixes the truncation error by allowing full time format (HH:MM:SS)
            $table->time('departure_time');

            // These are required for the new advanced Seeder logic
            $table->datetime('departure_datetime')->nullable();
            $table->datetime('estimated_arrival_datetime')->nullable();

            $table->decimal('price', 10, 2);
            $table->enum('status', ['scheduled', 'delayed', 'cancelled', 'completed'])->default('scheduled');
            $table->boolean('is_available_online')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
