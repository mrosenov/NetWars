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
        Schema::create('user_networks', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->id();
            $table->morphs('owner');
            $table->foreignId('hardware_id')->constrained('hardware_parts')->cascadeOnDelete();
            $table->string('ip')->unique();
            $table->string('user')->unique();
            $table->string('password', 8);
            $table->foreignId('connected_to_network_id')
                ->nullable()
                ->constrained('user_networks')
                ->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_networks');
    }
};
