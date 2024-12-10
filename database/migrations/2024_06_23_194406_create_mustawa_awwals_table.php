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
        Schema::create('mustawa_awwals', function (Blueprint $table) {
            $table->id();
            $table->string('kode_mk');
            $table->string('mk');
            $table->string('sks');
            $table->string('umsu_kode')->nullable();
            $table->string('umsu_mk')->nullable();
            $table->string('umsu_semester')->nullable();
            $table->string('stebis_kode')->nullable();
            $table->string('stebis_mk')->nullable();
            $table->string('stebis_semester')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mustawa_awwals');
    }
};
