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
        Schema::create('tahsins', function (Blueprint $table) {
            $table->id();
            $table->string('batch');
            $table->string('gelombang')->default(1);
            $table->string('title');
            $table->string('option');
            $table->text('description');
            $table->decimal('price_normal', 10, 0)->default(0);
            $table->decimal('price_alumni', 10, 0)->default(0);
            $table->string('session');
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tahsins');
    }
};
