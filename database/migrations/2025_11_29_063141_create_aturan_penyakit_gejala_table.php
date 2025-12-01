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
        Schema::create('aturan_penyakit_gejala', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('penyakit_id')->constrained('penyakit')->onDelete('cascade');
            $table->foreignUuid('gejala_id')->constrained('gejala')->onDelete('cascade');
            $table->decimal('bobot', 3, 2)->default(0.5);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aturan_penyakit_gejala');
    }
};
