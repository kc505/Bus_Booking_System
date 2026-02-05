<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('disputes', function (Blueprint $table) {
            // Step 1: Drop the old 'subject' column
            $table->dropColumn('subject');

            // Step 2: Add new 'title' column in the same position
            $table->string('title')->after('booking_id');  // adjust 'after' if position wrong
        });
    }

    public function down(): void
    {
        Schema::table('disputes', function (Blueprint $table) {
            // Reverse: drop title, add subject back
            $table->dropColumn('title');
            $table->string('subject')->after('booking_id');
        });
    }
};
