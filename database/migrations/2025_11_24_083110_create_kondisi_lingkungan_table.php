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
        Schema::create('kondisi_lingkungan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('suhu', ['rendah', 'normal', 'tinggi']);
            $table->enum('intensitas_cahaya', ['rendah', 'normal', 'tinggi']);
            $table->enum('ph_tanah', ['asam', 'netral', 'basa']);
            $table->enum('kelembapan_tanah', ['rendah', 'normal', 'tinggi']);
            $table->enum('kelembapan_udara', ['rendah', 'normal', 'tinggi']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kondisi_lingkungan');
    }
};
