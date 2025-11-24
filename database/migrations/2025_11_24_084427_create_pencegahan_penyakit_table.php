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
        Schema::create('pencegahan_penyakit', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('penyakit_id');
            $table->uuid('rekomendasi_pencegahan_id');
            $table->timestamps();

            $table->foreign('penyakit_id')->references('id')->on('penyakit')->onDelete('cascade');
            $table->foreign('rekomendasi_pencegahan_id')->references('id')->on('rekomendasi_pencegahan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pencegahan_penyakit');
    }
};
