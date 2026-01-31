<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataTrainingModel extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'dataset_training';
    protected $fillable = ['id', 'penyakit_id', 'gejala', 'lingkungan', 'created_at', 'updated_at'];

    // Casting JSON ke Array otomatis
    protected $casts = [
        'gejala' => 'array',     // Isi: ["ID-G01", "ID-G02"]
        'lingkungan' => 'array', // Isi: ["ID-L01", "ID-L02"]
    ];

    public function penyakit()
    {
        return $this->belongsTo(PenyakitModel::class);
    }
}
