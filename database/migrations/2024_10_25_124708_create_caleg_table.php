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
        Schema::create('caleg', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partai_id')->references('id')->on('partai_politik')->onDelete('cascade');
            $table->foreignId('daerah_pemilihan_id')->references('id')->on('daerah_pemilihan')->onDelete('cascade');
            $table->string('nama_lengkap');
            $table->enum('jenis_kelamin', ['l', 'p'])->default('l'); // l = laki - laki, p = perempuan
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('status')->nullable();
            $table->string('foto')->nullable();
            $table->text('alamat')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caleg');
    }
};
