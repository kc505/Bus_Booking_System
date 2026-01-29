<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('agencies', function (Blueprint $table) {
        if (!Schema::hasColumn('agencies', 'total_buses')) {
            $table->integer('total_buses')->default(0)->after('email');
            // You can change ->after('email') to match where you want it positioned
        }
    });
}

public function down(): void
{
    Schema::table('agencies', function (Blueprint $table) {
        if (Schema::hasColumn('agencies', 'total_buses')) {
            $table->dropColumn('total_buses');
        }
    });
}
};
