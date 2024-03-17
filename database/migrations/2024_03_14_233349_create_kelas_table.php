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
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('program_id');
            $table->unsignedBigInteger('user_id');
            $table->string('program');
            $table->string('batch');
            $table->string('class');
            $table->string('session');
            $table->string('room')->nullable();
            $table->string('level')->nullable();
            $table->string('score')->nullable();
            $table->string('lecturer')->nullable();
            $table->string('status')->default('Menunggu Update');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
