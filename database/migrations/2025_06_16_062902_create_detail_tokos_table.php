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
        Schema::create('detail_tokos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('toko_id')->unique(); // satu toko hanya punya satu detail

            // Informasi rekening
            $table->string('nama_bank')->nullable();
            $table->string('nomor_rekening')->nullable();
            $table->string('nama_pemilik_rekening')->nullable();

            // Kontak & sosial media
            $table->string('email_cs')->nullable();
            $table->string('whatsapp_cs')->nullable();
            $table->string('link_instagram')->nullable();
            $table->string('link_facebook')->nullable();
            $table->string('link_tiktok')->nullable();

            // Lokasi & operasional
            $table->string('link_google_maps')->nullable();
            $table->string('jam_operasional')->nullable();

            // Informasi tambahan
            $table->text('catatan_tambahan')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('toko_id')->references('id')->on('tokos')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_tokos');
    }
};
