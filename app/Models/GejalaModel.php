<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GejalaModel extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'gejala';
    protected $fillable = [
        'id',
        'nama',
        'deskripsi',
        'created_at',
        'updated_at',
    ];
}
