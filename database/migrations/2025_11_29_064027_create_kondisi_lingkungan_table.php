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
            $table->string('nama_parameter');
            $table->string('satuan')->nullable();
            $table->enum('nilai_label', ['rendah', 'normal', 'tinggi']);
            $table->decimal('min_value', 8, 2);
            $table->decimal('max_value', 8, 2);
            $table->text('deskripsi')->nullable();
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
