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
        Schema::create('aturan_penyakit_lingkungan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('penyakit_id')->constrained('penyakit')->onDelete('cascade');
            $table->foreignUuid('parameter_id')->constrained('parameter_lingkungan')->onDelete('cascade');
            $table->enum('kondisi', ['rendah', 'normal', 'tinggi'])->default('normal');
            $table->decimal('bobot_pengaruh', 3, 2)->default(0.3);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyakit_lingkungan');
    }
};
