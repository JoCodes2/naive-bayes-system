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
        Schema::create('penyakit', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('kode_penyakit')->unique();
            $table->string('nama_penyakit');
            $table->text('deskripsi');
            $table->text('solusi_perawatan');
            $table->text('tindakan_pencegahan');
            $table->text('faktor_risiko')->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyakit');
    }
};
