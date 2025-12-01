<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AturanPenyakitGejalaModel extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'aturan_penyakit_gejala';

    protected $fillable = [
        'id',
        'penyakit_id',
        'gejala_id',
        'bobot',
        'created_at',
        'updated_at',
    ];

    public function penyakit()
    {
        return $this->belongsTo(PenyakitModel::class, 'penyakit_id');
    }

    public function gejala()
    {
        return $this->belongsTo(GejalaModel::class, 'gejala_id');
    }
}
