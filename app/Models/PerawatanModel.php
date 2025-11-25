<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerawatanModel extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'perawatan';
    protected $fillable = [
        'id',
        'nama',
        'jenis',
        'deskripsi',
        'created_at',
        'updated_at',
    ];
}
