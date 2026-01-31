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
        Schema::create('hasil_diagnosa', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_petani')->nullable();
            $table->json('gejala_input');
            $table->json('lingkungan_input');
            $table->foreignUuid('penyakit_prediksi')->constrained('penyakit');
            $table->decimal('probabilitas', 8, 4);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_diagnosa');
    }
};
