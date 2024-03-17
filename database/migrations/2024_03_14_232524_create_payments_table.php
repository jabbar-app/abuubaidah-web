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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id');
            $table->foreignId('kelas_id');
            $table->foreignId('user_id');
            $table->string('external_id');
            $table->string('payer_name');
            $table->string('payer_email');
            $table->text('description');
            $table->decimal('amount', 10, 2);
            $table->string('invoice_url')->nullable();
            $table->string('status');
            $table->string('method')->default('Xendit');
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
