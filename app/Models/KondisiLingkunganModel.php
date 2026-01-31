<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KondisiLingkunganModel extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'kondisi_lingkungan';
    protected $fillable = ['id', 'nama_parameter', 'satuan', 'nilai_label', 'min_value', 'max_value', 'created_at', 'updated_at'];
}
