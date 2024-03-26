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
        Schema::create('kibas', function (Blueprint $table) {
            $table->id();
            $table->string('batch');
            $table->string('title');
            $table->string('option');
            $table->decimal('price_registration', 10, 0)->default(0);
            $table->decimal('price_spp', 10, 0)->default(0);
            $table->text('description');
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kibas');
    }
};
