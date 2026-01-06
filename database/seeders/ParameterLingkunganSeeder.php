<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;

class ParameterLingkunganSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        $parameter = [
            [
                'nama_parameter' => 'Kelembapan Udara',
                'satuan' => '%',
                'kategori' => 'udara',
                'nilai_ideal_min' => 60.00,
                'nilai_ideal_max' => 80.00,
                'deskripsi' => 'Kelembapan di atas 80% memicu jamur, di bawah 60% memicu thrips.'
            ],
            [
                'nama_parameter' => 'Suhu Udara',
                'satuan' => '°C',
                'kategori' => 'udara',
                'nilai_ideal_min' => 24.00,
                'nilai_ideal_max' => 30.00,
                'deskripsi' => 'Suhu panas (>32°C) mendukung perkembangan vektor virus seperti kutu kebul.'
            ],
            [
                'nama_parameter' => 'pH Tanah',
                'satuan' => 'pH',
                'kategori' => 'tanah',
                'nilai_ideal_min' => 6.00,
                'nilai_ideal_max' => 7.00,
                'deskripsi' => 'Tanah asam (pH < 5.5) sangat disukai oleh jamur Fusarium.'
            ],
            [
                'nama_parameter' => 'Kelembapan Tanah', // Parameter Baru
                'satuan' => '%',
                'kategori' => 'tanah',
                'nilai_ideal_min' => 60.00,
                'nilai_ideal_max' => 70.00,
                'deskripsi' => 'Tanah yang terlalu basah (>80%) memicu pembusukan akar dan perkembangan bakteri.'
            ],
            [
                'nama_parameter' => 'Curah Hujan',
                'satuan' => 'mm',
                'kategori' => 'air',
                'nilai_ideal_min' => 0.00,
                'nilai_ideal_max' => 100.00,
                'deskripsi' => 'Curah hujan tinggi meningkatkan risiko penyakit busuk buah dan bakteri.'
            ],
            [
                'nama_parameter' => 'Intensitas Cahaya',
                'satuan' => 'Lux',
                'kategori' => 'cahaya',
                'nilai_ideal_min' => 10000.00,
                'nilai_ideal_max' => 50000.00,
                'deskripsi' => 'Cahaya rendah/teduh memicu pertumbuhan Embun Tepung.'
            ],
        ];

        $data = array_map(function ($item) use ($now) {
            return array_merge($item, [
                'id' => Uuid::uuid4()->toString(),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }, $parameter);

        DB::table('parameter_lingkungan')->insert($data);
    }
}
