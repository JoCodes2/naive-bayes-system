<?php
// database/seeders/ParameterLingkunganSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class ParameterLingkunganSeeder extends Seeder
{
    public function run(): void
    {
        $parameter = [
            [
                'id' => Uuid::uuid4(),
                'nama_parameter' => 'Suhu Udara',
                'satuan' => '°C',
                'kategori' => 'udara',
                'nilai_ideal_min' => 24,
                'nilai_ideal_max' => 30,
                'deskripsi' => 'Suhu optimal untuk pertumbuhan cabai'
            ],
            [
                'id' => Uuid::uuid4(),
                'nama_parameter' => 'Kelembapan Udara',
                'satuan' => '%',
                'kategori' => 'udara',
                'nilai_ideal_min' => 60,
                'nilai_ideal_max' => 80,
                'deskripsi' => 'Tingkat kelembapan udara optimal'
            ],
            [
                'id' => Uuid::uuid4(),
                'nama_parameter' => 'pH Tanah',
                'satuan' => 'pH',
                'kategori' => 'tanah',
                'nilai_ideal_min' => 5.5,
                'nilai_ideal_max' => 6.8,
                'deskripsi' => 'Tingkat keasaman tanah optimal untuk cabai'
            ],
            [
                'id' => Uuid::uuid4(),
                'nama_parameter' => 'Intensitas Cahaya',
                'satuan' => 'lux',
                'kategori' => 'cahaya',
                'nilai_ideal_min' => 25000,
                'nilai_ideal_max' => 50000,
                'deskripsi' => 'Intensitas cahaya matahari optimal'
            ],
            [
                'id' => Uuid::uuid4(),
                'nama_parameter' => 'Curah Hujan',
                'satuan' => 'mm/hari',
                'kategori' => 'air',
                'nilai_ideal_min' => 2,
                'nilai_ideal_max' => 5,
                'deskripsi' => 'Curah hujan optimal untuk cabai'
            ],
            [
                'id' => Uuid::uuid4(),
                'nama_parameter' => 'Kelembapan Tanah',
                'satuan' => '%',
                'kategori' => 'tanah',
                'nilai_ideal_min' => 50,
                'nilai_ideal_max' => 70,
                'deskripsi' => 'Tingkat kelembapan tanah optimal'
            ],
            [
                'id' => Uuid::uuid4(),
                'nama_parameter' => 'Suhu Tanah',
                'satuan' => '°C',
                'kategori' => 'tanah',
                'nilai_ideal_min' => 22,
                'nilai_ideal_max' => 28,
                'deskripsi' => 'Suhu tanah optimal untuk perkembangan akar'
            ]
        ];

        DB::table('parameter_lingkungan')->insert($parameter);
    }
}
