<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilDiagnosaModel extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'hasil_diagnosa';
    protected $fillable = [
        'id',
        'nama_petani',
        'gejala_input',
        'lingkungan_input',
        'penyakit_prediksi',
        'probabilitas',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'gejala_input' => 'array',
        'lingkungan_input' => 'array',
    ];

    public function penyakit()
    {
        return $this->belongsTo(PenyakitModel::class, 'penyakit_prediksi');
    }
}
