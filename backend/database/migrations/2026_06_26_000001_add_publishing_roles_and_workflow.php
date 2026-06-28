<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('writer')->after('email');
            $table->boolean('is_active')->default(true)->after('role');
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id')->constrained()->nullOnDelete();
            $table->foreignId('reviewed_by_id')->nullable()->after('published_at')->constrained('users')->nullOnDelete();
            $table->foreignId('published_by_id')->nullable()->after('reviewed_by_id')->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable()->after('published_by_id');
            $table->text('editorial_notes')->nullable()->after('reviewed_at');
            $table->text('submission_notes')->nullable()->after('editorial_notes');
        });

        // Expand status beyond draft/published for editorial workflow
        // draft | submitted | changes_requested | published
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
            $table->dropConstrainedForeignId('reviewed_by_id');
            $table->dropConstrainedForeignId('published_by_id');
            $table->dropColumn(['reviewed_at', 'editorial_notes', 'submission_notes']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'is_active']);
        });
    }
};
