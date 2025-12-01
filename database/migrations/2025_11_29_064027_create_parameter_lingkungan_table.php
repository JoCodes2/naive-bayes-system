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
        Schema::create('parameter_lingkungan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_parameter');
            $table->string('satuan')->nullable();
            $table->string('kategori');
            $table->decimal('nilai_ideal_min', 8, 2)->nullable();
            $table->decimal('nilai_ideal_max', 8, 2)->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parameter_lingkungan_');
    }
};
