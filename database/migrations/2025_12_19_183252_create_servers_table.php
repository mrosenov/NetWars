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
        Schema::create('servers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();

            # Ownership (player-owned or npc)
            $table->enum('owner_type', ['player', 'npc'])->index();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            // Flexible attributes (npc archetype, tags, etc.)
            $table->json('meta')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servers');
    }
};
