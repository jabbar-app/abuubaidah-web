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
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->morphs('programmable');
            $table->decimal('price_pra', 10, 0)->default(0);
            $table->decimal('price_normal', 10, 0)->default(0);
            $table->decimal('price_alumni', 10, 0)->default(0);
            $table->date('deadline')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
