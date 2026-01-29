<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->foreignId('seat_id')->constrained()->onDelete('cascade');
            $table->string('ticket_number')->unique();
            $table->string('qr_code')->nullable();
            $table->string('passenger_name');
            $table->string('passenger_phone');
            $table->string('status')->default('active');
            $table->timestamp('checked_in_at')->nullable();
            $table->timestamp('expires_at')->nullable(); // Changed to nullable
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
