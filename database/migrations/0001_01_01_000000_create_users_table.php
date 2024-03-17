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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nik')->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone')->unique();
            $table->string('password');
            $table->string('gender')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('berat_badan')->nullable();
            $table->string('tinggi_badan')->nullable();
            $table->string('status_perkawinan')->nullable();
            $table->string('agama')->nullable();
            $table->string('suku')->nullable();
            $table->string('address')->nullable();
            $table->string('ukuran_almamater')->nullable();
            $table->string('nama_sd')->nullable();
            $table->string('lulus_sd')->nullable();
            $table->string('nama_smp')->nullable();
            $table->string('lulus_smp')->nullable();
            $table->string('nama_sma')->nullable();
            $table->string('lulus_sma')->nullable();
            $table->string('perguruan_tinggi')->nullable();
            $table->string('status_ayah')->nullable();
            $table->string('nama_ayah')->nullable();
            $table->string('pekerjaan_ayah')->nullable();
            $table->string('penghasilan_ayah')->nullable();
            $table->string('telp_ayah')->nullable();
            $table->string('status_ibu')->nullable();
            $table->string('nama_ibu')->nullable();
            $table->string('pekerjaan_ibu')->nullable();
            $table->string('penghasilan_ibu')->nullable();
            $table->string('telp_ibu')->nullable();
            $table->string('url_pas_foto')->nullable();
            $table->string('url_ktp')->nullable();
            $table->string('url_kk')->nullable();
            $table->string('url_ijazah')->nullable();
            $table->string('url_bilhaq')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
