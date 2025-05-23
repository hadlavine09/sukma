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
        Schema::create('tokos', function (Blueprint $table) {
            $table->id();
            $table->string('no_toko');
            $table->unsignedBigInteger('user_id');
            $table->string('nama_toko');
            $table->string('slug_toko')->unique();
            $table->string('logo_toko')->nullable();
            $table->string('no_hp_toko');
            $table->string('alamat_toko');
            $table->string('pemilik_toko');
            $table->text('deskripsi_toko')->nullable();
            $table->boolean('status_aktif_toko')->default(true);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tokos');
    }
};
