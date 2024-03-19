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
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nik');
            $table->string('email');
            $table->string('password');
            $table->string('gender');
            $table->string('phone');
            $table->string('program');
            $table->string('batch');
            $table->string('level');
            $table->string('session');
            $table->string('class');
            $table->string('score');
            $table->string('next');
            $table->string('lecturer');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};
