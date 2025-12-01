<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AturanPenyakitLingkunganModel extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'aturan_penyakit_lingkungan';

    protected $fillable = [
        'id',
        'penyakit_id',
        'parameter_id',
        'kondisi',
        'bobot_pengaruh',
        'created_at',
        'updated_at'
    ];

    public function penyakit()
    {
        return $this->belongsTo(PenyakitModel::class, 'penyakit_id');
    }

    public function parameter()
    {
        return $this->belongsTo(ParameterLingkunganModel::class, 'parameter_id');
    }
}
