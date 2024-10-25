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
        Schema::create('daerah_pemilihan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tahun_pemilihan_id')->references('id')->on('tahun_pemilihan')->onDelete('cascade');
            $table->string('nama_daerah');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daerah_pemilihan');
    }
};
