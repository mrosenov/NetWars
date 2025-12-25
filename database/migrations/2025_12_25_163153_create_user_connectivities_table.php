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
        Schema::create('user_connectivities', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->id();
            $table->morphs('owner');
            $table->foreignId('service_id')->constrained('hardware_parts')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_connectivities');
    }
};
