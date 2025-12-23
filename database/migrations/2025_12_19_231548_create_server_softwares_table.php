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
        Schema::create('software', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();

            $table->foreignId('server_id')->constrained('servers')->cascadeOnDelete();
            $table->enum('type', ['crc', 'hash', 'scan', 'exp', 'fwl', 'hdr', 'skr', 'vspam', 'vwarez', 'vddos', 'vcol', 'vminer', 'vbrk', 'nmap', 'ana']);
            $table->string('name');
            $table->float('version',1);
            $table->integer('size');
            $table->json('requirements')->nullable();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->boolean('is_hidden')->default(false);
            $table->timestamps();

            $table->index(['server_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('software');
    }
};
