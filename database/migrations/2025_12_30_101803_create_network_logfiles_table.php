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
        Schema::create('network_logfiles', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->unsignedBigInteger('network_id')->primary();
            $table->foreign('network_id')->references('id')->on('user_networks')->cascadeOnDelete();

            $table->longText('content')->nullable();
            $table->unsignedInteger('tamper_count')->default(0);
            $table->timestamp('last_tampered_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('network_logfiles');
    }
};
