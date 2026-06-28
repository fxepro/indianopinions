<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('layout_slots', function (Blueprint $table) {
            $table->id();
            $table->string('page');
            $table->string('section');
            $table->unsignedSmallInteger('position')->default(0);
            $table->string('hub_slug')->nullable();
            $table->foreignId('post_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();

            $table->unique(['page', 'section', 'position', 'hub_slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('layout_slots');
    }
};
