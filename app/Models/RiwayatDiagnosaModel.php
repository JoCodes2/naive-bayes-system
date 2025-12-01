<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatDiagnosaModel extends Model
{

    use HasFactory, HasUuids;

    protected $table = 'riwayat_diagnosa';
    protected $fillable = [
        'id',
        'kondisi_lingkungan',
        'gejala_yang_dipilih',
        'penyakit_id',
        'tingkat_kepercayaan',
        'rekomendasi_perawatan',
        'rekomendasi_pencegahan',
        'catatan_tambahan',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'kondisi_lingkungan' => 'array',
        'gejala_yang_dipilih' => 'array',
    ];
}
