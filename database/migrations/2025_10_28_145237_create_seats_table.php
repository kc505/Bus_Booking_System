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
        Schema::create('seats', function (Blueprint $table) {
            $table->id(); // This is the 'seat_id' referenced by tickets
            $table->foreignId('bus_id')->constrained()->onDelete('cascade');

            // This MUST be 'seat_number' (The label: 1, 2, 3...)
            // If you name this 'seat_id', it conflicts with the primary key above
            $table->integer('seat_number');

            $table->enum('side', ['left', 'right'])->nullable();

            // Fixed the error: Changed enum to string so 'standard' is allowed
            $table->string('class')->default('standard');

            $table->boolean('is_available_online')->default(true);
            $table->timestamps();

            // Ensures a bus can't have two seats with number "5"
            $table->unique(['bus_id', 'seat_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
};
