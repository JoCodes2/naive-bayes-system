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
        Schema::create('riwayat_diagnosa', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->json('kondisi_lingkungan');
            $table->json('gejala_yang_dipilih');
            $table->foreignUuid('penyakit_id')->constrained('penyakit')->onDelete('cascade');
            $table->decimal('tingkat_kepercayaan', 5, 2);
            $table->text('rekomendasi_perawatan');
            $table->text('rekomendasi_pencegahan');
            $table->text('catatan_tambahan')->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_diagnosa');
    }
};
