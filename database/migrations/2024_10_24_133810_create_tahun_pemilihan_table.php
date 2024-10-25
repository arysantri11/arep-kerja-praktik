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
        Schema::create('tahun_pemilihan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lembaga_legislatif_id')->references('id')->on('lembaga_legislatif')->onDelete('cascade');
            $table->year('tahun');
            $table->date('tanggal')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tahun_pemilihan');
    }
};
