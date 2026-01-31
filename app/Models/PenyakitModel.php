<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenyakitModel extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'penyakit';
    protected $fillable = ['id', 'kode_penyakit', 'nama_penyakit', 'deskripsi', 'solusi_treatment', 'pencegahan', 'created_at', 'updated_at'];

    // Relasi ke Dataset Training
    public function datasets()
    {
        return $this->hasMany(DataTrainingModel::class);
    }

    // Relasi ke Hasil Diagnosa
    public function riwayatDiagnosa()
    {
        return $this->hasMany(HasilDiagnosaModel::class, 'penyakit_prediksi');
    }
}
