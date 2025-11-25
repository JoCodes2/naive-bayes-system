<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekomendasiPencegahanModel extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'rekomendasi_pencegahan';
    protected $fillable = ['id', 'judul', 'deskripsi', 'created_at', 'updated_at'];
}
