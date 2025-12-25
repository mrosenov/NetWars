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
        Schema::create('server_resources', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();

            $table->foreignId('server_id')->constrained('servers')->cascadeOnDelete();
            $table->morphs('owner');
//            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
//            $table->foreignId('npc_id')->nullable()->constrained('npc')->cascadeOnDelete();
            $table->foreignId('hardware_id')->constrained('hardware_parts')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('server_resources');
    }
};
