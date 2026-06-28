<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::table('users')->where('role', 'admin')->update(['role' => 'editor']);

        DB::table('posts')->where('status', 'in_review')->update(['status' => 'submitted']);
        DB::table('posts')->where('status', 'rejected')->update(['status' => 'changes_requested']);
    }

    public function down(): void
    {
        // Legacy statuses cannot be restored reliably.
    }
};
