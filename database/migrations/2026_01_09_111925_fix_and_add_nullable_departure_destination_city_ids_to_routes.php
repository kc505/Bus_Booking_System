<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('routes', function (Blueprint $table) {
            // Drop columns if they exist (safe, won't error if missing)
            if (Schema::hasColumn('routes', 'departure_city_id')) {
                $table->dropColumn('departure_city_id');
            }
            if (Schema::hasColumn('routes', 'destination_city_id')) {
                $table->dropColumn('destination_city_id');
            }

            // Add the columns as nullable foreign keys
            $table->foreignId('departure_city_id')
                ->nullable()
                ->constrained('cities')
                ->onDelete('cascade');

            $table->foreignId('destination_city_id')
                ->nullable()
                ->constrained('cities')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('routes', function (Blueprint $table) {
            $table->dropColumn(['departure_city_id', 'destination_city_id']);
        });
    }
};
