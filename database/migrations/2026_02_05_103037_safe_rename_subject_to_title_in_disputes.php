<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('disputes', function (Blueprint $table) {
            // Step 1: Drop foreign key if it exists (adjust name if different)
            // Run SHOW CREATE TABLE disputes; to get exact foreign key name
            // Example: disputes_subject_foreign
            $table->dropForeign('disputes_subject_foreign'); // ← change if name different

            // Step 2: Drop index if exists (optional)
            $table->dropIndex(['subject']);

            // Step 3: Rename column
            $table->renameColumn('subject', 'title');

            // Step 4: Re-add foreign key ONLY if there was one originally
            // Uncomment and adjust if subject was foreign key (e.g. to users.id)
            // $table->foreign('title')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('disputes', function (Blueprint $table) {
            // Reverse rename
            $table->renameColumn('title', 'subject');

            // Re-add original foreign key if needed
            // $table->foreign('subject')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
