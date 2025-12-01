<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParameterLingkunganModel extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'parameter_lingkungan';

    protected $fillable = [
        'id',
        'nama_parameter',
        'satuan',
        'kategori',
        'nilai_ideal_min',
        'nilai_ideal_max',
        'deskripsi',
        'created_at',
        'updated_at'
    ];
}
