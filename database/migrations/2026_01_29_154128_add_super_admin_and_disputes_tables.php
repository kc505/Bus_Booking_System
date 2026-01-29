<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add role column to users table
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['super_admin', 'agency_admin', 'checkin_staff', 'passenger'])
                      ->default('passenger')
                      ->after('is_admin');
            }
            if (!Schema::hasColumn('users', 'status')) {
                $table->enum('status', ['active', 'suspended', 'inactive'])
                      ->default('active')
                      ->after('role');
            }
        });

        // Add status to agencies table
        Schema::table('agencies', function (Blueprint $table) {
            if (!Schema::hasColumn('agencies', 'status')) {
                $table->enum('status', ['active', 'suspended', 'inactive'])
                      ->default('active')
                      ->after('is_active');
            }
            if (!Schema::hasColumn('agencies', 'suspended_at')) {
                $table->timestamp('suspended_at')->nullable()->after('status');
            }
            if (!Schema::hasColumn('agencies', 'suspension_reason')) {
                $table->text('suspension_reason')->nullable()->after('suspended_at');
            }
        });

        // Create disputes table
        Schema::create('disputes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('agency_id')->constrained()->onDelete('cascade');
            $table->foreignId('booking_id')->nullable()->constrained('multi_agency_bookings')->onDelete('set null');
            $table->string('subject');
            $table->text('description');
            $table->enum('status', ['pending', 'in_progress', 'resolved', 'rejected'])->default('pending');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->text('admin_response')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->foreignId('resolved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('disputes');

        Schema::table('agencies', function (Blueprint $table) {
            $table->dropColumn(['status', 'suspended_at', 'suspension_reason']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'status']);
        });
    }
};
