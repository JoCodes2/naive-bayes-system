<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenyakitModel extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'penyakit';

    protected $fillable = [
        'id',
        'kode_penyakit',
        'nama_penyakit',
        'deskripsi',
        'solusi_perawatan',
        'tindakan_pencegahan',
        'faktor_risiko',
        'created_at',
        'updated_at'
    ];

    public function aturanGejala()
    {
        return $this->hasMany(AturanGejalaModel::class, 'penyakit_id');
    }

    public function aturanLingkungan()
    {
        return $this->hasMany(AturanPenyakitLingkunganModel::class, 'penyakit_id');
    }
}
