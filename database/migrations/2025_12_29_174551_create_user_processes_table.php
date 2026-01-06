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
        Schema::create('user_processes', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('resource_type', ['cpu', 'ram', 'disk', 'network']);
            $table->enum('action', ['install', 'uninstall', 'log', 'bruteforce', 'scan', 'ssh', 'ftp', 'download', 'upload']);
            $table->json('metadata')->nullable();
            $table->unsignedBigInteger('work_units');
            $table->float('ideal_seconds');
            $table->unsignedInteger('remaining_ideal_seconds')->nullable();
            $table->unsignedInteger('ideal_done')->default(0);
            $table->timestamp('last_progress_at')->nullable()->index();
            $table->unsignedInteger('cpu_power_snapshot');
            $table->unsignedTinyInteger('share_percent')->default(100);
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->enum('status', ['running', 'completed', 'failed', 'canceled'])->default('running');
            $table->timestamps();

            $table->index(['user_id', 'resource_type', 'status']);
            $table->index(['user_id', 'ends_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_processes');
    }
};
