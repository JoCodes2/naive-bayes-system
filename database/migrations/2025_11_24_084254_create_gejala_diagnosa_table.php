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
        Schema::create('gejala_diagnosa', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('gejala_id');
            $table->uuid('diagnosa_id');
            $table->timestamps();

            $table->foreign('gejala_id')->references('id')->on('gejala')->onDelete('cascade');
            $table->foreign('diagnosa_id')->references('id')->on('catatan_diagnosa')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gejala_diagnosa');
    }
};
