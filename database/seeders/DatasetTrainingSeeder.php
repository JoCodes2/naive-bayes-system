<?php

namespace Database\Seeders;

use App\Models\DataTrainingModel;
use App\Models\PenyakitModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatasetTrainingSeeder extends Seeder
{
    public function run(): void
    {
        $dataset = [
            // P01 - Layu Fusarium
            ['kode' => 'P01', 'gejala' => ['G01', 'G15', 'G17'], 'lingkungan' => ['Suhu Udara' => 'normal', 'Kelembapan Udara' => 'normal', 'Kelembapan Tanah' => 'normal', 'Intensitas Cahaya' => 'normal', 'Curah Hujan' => 'rendah', 'pH Tanah' => 'rendah']],
            ['kode' => 'P01', 'gejala' => ['G01', 'G14', 'G16'], 'lingkungan' => ['Suhu Udara' => 'rendah', 'Kelembapan Udara' => 'tinggi', 'Kelembapan Tanah' => 'normal', 'Intensitas Cahaya' => 'rendah', 'Curah Hujan' => 'normal', 'pH Tanah' => 'rendah']],
            ['kode' => 'P01', 'gejala' => ['G01', 'G15', 'G24'], 'lingkungan' => ['Suhu Udara' => 'normal', 'Kelembapan Udara' => 'rendah', 'Kelembapan Tanah' => 'rendah', 'Intensitas Cahaya' => 'tinggi', 'Curah Hujan' => 'rendah', 'pH Tanah' => 'rendah']],

            // P02 - Embun Tepung
            ['kode' => 'P02', 'gejala' => ['G05', 'G16', 'G24'], 'lingkungan' => ['Suhu Udara' => 'normal', 'Kelembapan Udara' => 'tinggi', 'Kelembapan Tanah' => 'normal', 'Intensitas Cahaya' => 'normal', 'Curah Hujan' => 'normal', 'pH Tanah' => 'normal']],
            ['kode' => 'P02', 'gejala' => ['G05', 'G14'], 'lingkungan' => ['Suhu Udara' => 'rendah', 'Kelembapan Udara' => 'tinggi', 'Kelembapan Tanah' => 'normal', 'Intensitas Cahaya' => 'rendah', 'Curah Hujan' => 'tinggi', 'pH Tanah' => 'normal']],
            ['kode' => 'P02', 'gejala' => ['G05', 'G24', 'G16'], 'lingkungan' => ['Suhu Udara' => 'normal', 'Kelembapan Udara' => 'normal', 'Kelembapan Tanah' => 'rendah', 'Intensitas Cahaya' => 'rendah', 'Curah Hujan' => 'normal', 'pH Tanah' => 'normal']],

            // P03 - Virus Kuning
            ['kode' => 'P03', 'gejala' => ['G06', 'G03', 'G14'], 'lingkungan' => ['Suhu Udara' => 'tinggi', 'Kelembapan Udara' => 'rendah', 'Kelembapan Tanah' => 'rendah', 'Intensitas Cahaya' => 'tinggi', 'Curah Hujan' => 'rendah', 'pH Tanah' => 'normal']],
            ['kode' => 'P03', 'gejala' => ['G06', 'G19', 'G14'], 'lingkungan' => ['Suhu Udara' => 'tinggi', 'Kelembapan Udara' => 'normal', 'Kelembapan Tanah' => 'normal', 'Intensitas Cahaya' => 'tinggi', 'Curah Hujan' => 'rendah', 'pH Tanah' => 'tinggi']],
            ['kode' => 'P03', 'gejala' => ['G06', 'G16', 'G19'], 'lingkungan' => ['Suhu Udara' => 'normal', 'Kelembapan Udara' => 'rendah', 'Kelembapan Tanah' => 'rendah', 'Intensitas Cahaya' => 'tinggi', 'Curah Hujan' => 'rendah', 'pH Tanah' => 'normal']],

            // P04 - Layu Bakteri
            ['kode' => 'P04', 'gejala' => ['G02', 'G13', 'G21'], 'lingkungan' => ['Suhu Udara' => 'tinggi', 'Kelembapan Udara' => 'tinggi', 'Kelembapan Tanah' => 'tinggi', 'Intensitas Cahaya' => 'normal', 'Curah Hujan' => 'tinggi', 'pH Tanah' => 'rendah']],
            ['kode' => 'P04', 'gejala' => ['G02', 'G15', 'G23'], 'lingkungan' => ['Suhu Udara' => 'normal', 'Kelembapan Udara' => 'tinggi', 'Kelembapan Tanah' => 'tinggi', 'Intensitas Cahaya' => 'rendah', 'Curah Hujan' => 'tinggi', 'pH Tanah' => 'rendah']],
            ['kode' => 'P04', 'gejala' => ['G13', 'G23', 'G15'], 'lingkungan' => ['Suhu Udara' => 'tinggi', 'Kelembapan Udara' => 'normal', 'Kelembapan Tanah' => 'tinggi', 'Intensitas Cahaya' => 'normal', 'Curah Hujan' => 'normal', 'pH Tanah' => 'rendah']],

            // P05 - Antraknosa
            ['kode' => 'P05', 'gejala' => ['G09', 'G16', 'G18'], 'lingkungan' => ['Suhu Udara' => 'tinggi', 'Kelembapan Udara' => 'tinggi', 'Kelembapan Tanah' => 'normal', 'Intensitas Cahaya' => 'normal', 'Curah Hujan' => 'tinggi', 'pH Tanah' => 'normal']],
            ['kode' => 'P05', 'gejala' => ['G09', 'G05', 'G16'], 'lingkungan' => ['Suhu Udara' => 'normal', 'Kelembapan Udara' => 'tinggi', 'Kelembapan Tanah' => 'tinggi', 'Intensitas Cahaya' => 'rendah', 'Curah Hujan' => 'normal', 'pH Tanah' => 'rendah']],
            ['kode' => 'P05', 'gejala' => ['G09', 'G18'], 'lingkungan' => ['Suhu Udara' => 'tinggi', 'Kelembapan Udara' => 'normal', 'Kelembapan Tanah' => 'normal', 'Intensitas Cahaya' => 'tinggi', 'Curah Hujan' => 'normal', 'pH Tanah' => 'normal']],

            // P06 - Bercak Daun
            ['kode' => 'P06', 'gejala' => ['G05', 'G01', 'G16'], 'lingkungan' => ['Suhu Udara' => 'normal', 'Kelembapan Udara' => 'tinggi', 'Kelembapan Tanah' => 'normal', 'Intensitas Cahaya' => 'normal', 'Curah Hujan' => 'tinggi', 'pH Tanah' => 'normal']],
            ['kode' => 'P06', 'gejala' => ['G05', 'G16'], 'lingkungan' => ['Suhu Udara' => 'rendah', 'Kelembapan Udara' => 'tinggi', 'Kelembapan Tanah' => 'rendah', 'Intensitas Cahaya' => 'rendah', 'Curah Hujan' => 'normal', 'pH Tanah' => 'normal']],
            ['kode' => 'P06', 'gejala' => ['G05', 'G01', 'G14'], 'lingkungan' => ['Suhu Udara' => 'normal', 'Kelembapan Udara' => 'tinggi', 'Kelembapan Tanah' => 'tinggi', 'Intensitas Cahaya' => 'rendah', 'Curah Hujan' => 'tinggi', 'pH Tanah' => 'rendah']],

            // P07 - Hama Thrips
            ['kode' => 'P07', 'gejala' => ['G03', 'G07', 'G14'], 'lingkungan' => ['Suhu Udara' => 'tinggi', 'Kelembapan Udara' => 'rendah', 'Kelembapan Tanah' => 'rendah', 'Intensitas Cahaya' => 'tinggi', 'Curah Hujan' => 'rendah', 'pH Tanah' => 'normal']],
            ['kode' => 'P07', 'gejala' => ['G03', 'G24', 'G07'], 'lingkungan' => ['Suhu Udara' => 'tinggi', 'Kelembapan Udara' => 'normal', 'Kelembapan Tanah' => 'rendah', 'Intensitas Cahaya' => 'normal', 'Curah Hujan' => 'rendah', 'pH Tanah' => 'rendah']],
            ['kode' => 'P07', 'gejala' => ['G03', 'G07'], 'lingkungan' => ['Suhu Udara' => 'tinggi', 'Kelembapan Udara' => 'rendah', 'Kelembapan Tanah' => 'rendah', 'Intensitas Cahaya' => 'tinggi', 'Curah Hujan' => 'rendah', 'pH Tanah' => 'normal']],

            // P08 - Bercak Bakteri
            ['kode' => 'P08', 'gejala' => ['G05', 'G10', 'G21'], 'lingkungan' => ['Suhu Udara' => 'normal', 'Kelembapan Udara' => 'tinggi', 'Kelembapan Tanah' => 'tinggi', 'Intensitas Cahaya' => 'rendah', 'Curah Hujan' => 'tinggi', 'pH Tanah' => 'rendah']],
            ['kode' => 'P08', 'gejala' => ['G05', 'G16', 'G22'], 'lingkungan' => ['Suhu Udara' => 'tinggi', 'Kelembapan Udara' => 'tinggi', 'Kelembapan Tanah' => 'tinggi', 'Intensitas Cahaya' => 'rendah', 'Curah Hujan' => 'normal', 'pH Tanah' => 'rendah']],
            ['kode' => 'P08', 'gejala' => ['G10', 'G21', 'G22'], 'lingkungan' => ['Suhu Udara' => 'normal', 'Kelembapan Udara' => 'tinggi', 'Kelembapan Tanah' => 'tinggi', 'Intensitas Cahaya' => 'normal', 'Curah Hujan' => 'tinggi', 'pH Tanah' => 'normal']],

            // P09 - Mosaik Virus
            ['kode' => 'P09', 'gejala' => ['G06', 'G14', 'G03'], 'lingkungan' => ['Suhu Udara' => 'normal', 'Kelembapan Udara' => 'normal', 'Kelembapan Tanah' => 'normal', 'Intensitas Cahaya' => 'normal', 'Curah Hujan' => 'rendah', 'pH Tanah' => 'normal']],
            ['kode' => 'P09', 'gejala' => ['G06', 'G04', 'G14'], 'lingkungan' => ['Suhu Udara' => 'tinggi', 'Kelembapan Udara' => 'rendah', 'Kelembapan Tanah' => 'rendah', 'Intensitas Cahaya' => 'tinggi', 'Curah Hujan' => 'rendah', 'pH Tanah' => 'normal']],
            ['kode' => 'P09', 'gejala' => ['G06', 'G14'], 'lingkungan' => ['Suhu Udara' => 'normal', 'Kelembapan Udara' => 'normal', 'Kelembapan Tanah' => 'rendah', 'Intensitas Cahaya' => 'normal', 'Curah Hujan' => 'rendah', 'pH Tanah' => 'normal']],

            // P10 - Busuk Phytophthora
            ['kode' => 'P10', 'gejala' => ['G12', 'G17', 'G21'], 'lingkungan' => ['Suhu Udara' => 'normal', 'Kelembapan Udara' => 'tinggi', 'Kelembapan Tanah' => 'tinggi', 'Intensitas Cahaya' => 'rendah', 'Curah Hujan' => 'tinggi', 'pH Tanah' => 'rendah']],
            ['kode' => 'P10', 'gejala' => ['G12', 'G10', 'G15'], 'lingkungan' => ['Suhu Udara' => 'rendah', 'Kelembapan Udara' => 'tinggi', 'Kelembapan Tanah' => 'tinggi', 'Intensitas Cahaya' => 'rendah', 'Curah Hujan' => 'tinggi', 'pH Tanah' => 'normal']],
            ['kode' => 'P10', 'gejala' => ['G12', 'G17', 'G15'], 'lingkungan' => ['Suhu Udara' => 'normal', 'Kelembapan Udara' => 'tinggi', 'Kelembapan Tanah' => 'tinggi', 'Intensitas Cahaya' => 'rendah', 'Curah Hujan' => 'normal', 'pH Tanah' => 'rendah']],
        ];

        foreach ($dataset as $data) {
            $penyakit = PenyakitModel::where('kode_penyakit', $data['kode'])->first();

            if ($penyakit) {
                DataTrainingModel::create([
                    'id' => (string) Str::uuid(),
                    'penyakit_id' => $penyakit->id,
                    'gejala' => $data['gejala'],
                    'lingkungan' => $data['lingkungan'],
                ]);
            }
        }
    }
}
