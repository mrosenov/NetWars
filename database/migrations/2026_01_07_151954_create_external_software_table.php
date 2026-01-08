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
        Schema::create('external_software', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();

            $table->morphs('owner');
            $table->enum('type', ['crc', 'hash', 'scan', 'exp', 'fwl', 'hdr', 'skr', 'vspam', 'vwarez', 'vddos', 'vcol', 'vminer', 'vbrk', 'nmap', 'ana', 'puzzle']);
            $table->string('name');
            $table->decimal('version', 10, 1)->default(1.0);
            $table->bigInteger('size');
            $table->json('requirements')->nullable();
            $table->timestamps();

            $table->index(['name', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('external_software');
    }
};
