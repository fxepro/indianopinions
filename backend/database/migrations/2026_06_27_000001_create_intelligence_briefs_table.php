<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('intelligence_briefs', function (Blueprint $table) {
            $table->id();
            $table->date('edition_date')->unique();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        Schema::create('intelligence_brief_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('intelligence_brief_id')->constrained()->cascadeOnDelete();
            $table->string('type'); // lead | hub
            $table->string('hub_slug')->nullable();
            $table->unsignedSmallInteger('position')->default(0);
            $table->string('headline')->nullable();
            $table->text('blurb');
            $table->foreignId('post_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();

            $table->unique(['intelligence_brief_id', 'type', 'hub_slug', 'position']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('intelligence_brief_items');
        Schema::dropIfExists('intelligence_briefs');
    }
};
