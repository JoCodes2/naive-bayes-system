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
        Schema::create('gejala', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('kode_gejala')->unique();
            $table->string('nama_gejala');
            $table->text('deskripsi')->nullable(); // Tambahkan kolom ini
            $table->enum('kategori', ['akar', 'daun', 'buah', 'batang', 'umum'])->default('umum');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gejala');
    }
};
