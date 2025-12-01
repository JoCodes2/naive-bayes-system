<?php
// database/seeders/AturanPenyakitGejalaSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class AturanPenyakitGejalaSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua penyakit dan gejala
        $penyakit = DB::table('penyakit')->get();
        $gejala = DB::table('gejala')->get();

        $aturan = [];

        // Aturan untuk Antraknosa (P001)
        $aturan[] = ['penyakit_id' => $penyakit->where('kode_penyakit', 'P001')->first()->id, 'gejala_id' => $gejala->where('kode_gejala', 'G011')->first()->id, 'bobot' => 0.9]; // Buah busuk
        $aturan[] = ['penyakit_id' => $penyakit->where('kode_penyakit', 'P001')->first()->id, 'gejala_id' => $gejala->where('kode_gejala', 'G012')->first()->id, 'bobot' => 0.8]; // Bercak pada buah
        $aturan[] = ['penyakit_id' => $penyakit->where('kode_penyakit', 'P001')->first()->id, 'gejala_id' => $gejala->where('kode_gejala', 'G003')->first()->id, 'bobot' => 0.6]; // Bercak coklat pada daun

        // Aturan untuk Layu Fusarium (P002)
        $aturan[] = ['penyakit_id' => $penyakit->where('kode_penyakit', 'P002')->first()->id, 'gejala_id' => $gejala->where('kode_gejala', 'G004')->first()->id, 'bobot' => 0.9]; // Daun layu
        $aturan[] = ['penyakit_id' => $penyakit->where('kode_penyakit', 'P002')->first()->id, 'gejala_id' => $gejala->where('kode_gejala', 'G027')->first()->id, 'bobot' => 0.7]; // Pertumbuhan terhambat
        $aturan[] = ['penyakit_id' => $penyakit->where('kode_penyakit', 'P002')->first()->id, 'gejala_id' => $gejala->where('kode_gejala', 'G001')->first()->id, 'bobot' => 0.6]; // Daun menguning

        // Aturan untuk Bercak Daun Cercospora (P003)
        $aturan[] = ['penyakit_id' => $penyakit->where('kode_penyakit', 'P003')->first()->id, 'gejala_id' => $gejala->where('kode_gejala', 'G003')->first()->id, 'bobot' => 0.8]; // Bercak coklat pada daun
        $aturan[] = ['penyakit_id' => $penyakit->where('kode_penyakit', 'P003')->first()->id, 'gejala_id' => $gejala->where('kode_gejala', 'G010')->first()->id, 'bobot' => 0.7]; // Daun rontok prematur
        $aturan[] = ['penyakit_id' => $penyakit->where('kode_penyakit', 'P003')->first()->id, 'gejala_id' => $gejala->where('kode_gejala', 'G001')->first()->id, 'bobot' => 0.5]; // Daun menguning

        // Aturan untuk Busuk Daun Phytophthora (P004)
        $aturan[] = ['penyakit_id' => $penyakit->where('kode_penyakit', 'P004')->first()->id, 'gejala_id' => $gejala->where('kode_gejala', 'G004')->first()->id, 'bobot' => 0.8]; // Daun layu
        $aturan[] = ['penyakit_id' => $penyakit->where('kode_penyakit', 'P004')->first()->id, 'gejala_id' => $gejala->where('kode_gejala', 'G016')->first()->id, 'bobot' => 0.7]; // Batang busuk
        $aturan[] = ['penyakit_id' => $penyakit->where('kode_penyakit', 'P004')->first()->id, 'gejala_id' => $gejala->where('kode_gejala', 'G011')->first()->id, 'bobot' => 0.6]; // Buah busuk

        // Aturan untuk Kerdil Virus CMV (P005)
        $aturan[] = ['penyakit_id' => $penyakit->where('kode_penyakit', 'P005')->first()->id, 'gejala_id' => $gejala->where('kode_gejala', 'G002')->first()->id, 'bobot' => 0.8]; // Daun keriting
        $aturan[] = ['penyakit_id' => $penyakit->where('kode_penyakit', 'P005')->first()->id, 'gejala_id' => $gejala->where('kode_gejala', 'G026')->first()->id, 'bobot' => 0.9]; // Tanaman kerdil
        $aturan[] = ['penyakit_id' => $penyakit->where('kode_penyakit', 'P005')->first()->id, 'gejala_id' => $gejala->where('kode_gejala', 'G014')->first()->id, 'bobot' => 0.7]; // Buah kecil tidak normal

        // Aturan untuk Busuk Leher Batang (P006)
        $aturan[] = ['penyakit_id' => $penyakit->where('kode_penyakit', 'P006')->first()->id, 'gejala_id' => $gejala->where('kode_gejala', 'G016')->first()->id, 'bobot' => 0.9]; // Batang busuk
        $aturan[] = ['penyakit_id' => $penyakit->where('kode_penyakit', 'P006')->first()->id, 'gejala_id' => $gejala->where('kode_gejala', 'G004')->first()->id, 'bobot' => 0.8]; // Daun layu
        $aturan[] = ['penyakit_id' => $penyakit->where('kode_penyakit', 'P006')->first()->id, 'gejala_id' => $gejala->where('kode_gejala', 'G020')->first()->id, 'bobot' => 0.6]; // Bengkak pada batang

        // Aturan untuk Embun Tepung (P007)
        $aturan[] = ['penyakit_id' => $penyakit->where('kode_penyakit', 'P007')->first()->id, 'gejala_id' => $gejala->where('kode_gejala', 'G006')->first()->id, 'bobot' => 0.9]; // Lapisan tepung putih pada daun
        $aturan[] = ['penyakit_id' => $penyakit->where('kode_penyakit', 'P007')->first()->id, 'gejala_id' => $gejala->where('kode_gejala', 'G001')->first()->id, 'bobot' => 0.7]; // Daun menguning
        $aturan[] = ['penyakit_id' => $penyakit->where('kode_penyakit', 'P007')->first()->id, 'gejala_id' => $gejala->where('kode_gejala', 'G010')->first()->id, 'bobot' => 0.6]; // Daun rontok prematur

        // Aturan untuk Layu Bakteri (P008)
        $aturan[] = ['penyakit_id' => $penyakit->where('kode_penyakit', 'P008')->first()->id, 'gejala_id' => $gejala->where('kode_gejala', 'G004')->first()->id, 'bobot' => 0.9]; // Daun layu
        $aturan[] = ['penyakit_id' => $penyakit->where('kode_penyakit', 'P008')->first()->id, 'gejala_id' => $gejala->where('kode_gejala', 'G018')->first()->id, 'bobot' => 0.8]; // Lendir pada batang
        $aturan[] = ['penyakit_id' => $penyakit->where('kode_penyakit', 'P008')->first()->id, 'gejala_id' => $gejala->where('kode_gejala', 'G030')->first()->id, 'bobot' => 0.7]; // Tanaman mudah layu

        // Aturan untuk Bercak Bakteri (P009)
        $aturan[] = ['penyakit_id' => $penyakit->where('kode_penyakit', 'P009')->first()->id, 'gejala_id' => $gejala->where('kode_gejala', 'G003')->first()->id, 'bobot' => 0.8]; // Bercak coklat pada daun
        $aturan[] = ['penyakit_id' => $penyakit->where('kode_penyakit', 'P009')->first()->id, 'gejala_id' => $gejala->where('kode_gejala', 'G012')->first()->id, 'bobot' => 0.7]; // Bercak pada buah
        $aturan[] = ['penyakit_id' => $penyakit->where('kode_penyakit', 'P009')->first()->id, 'gejala_id' => $gejala->where('kode_gejala', 'G009')->first()->id, 'bobot' => 0.6]; // Daun berlubang

        // Aturan untuk Busuk Akar (P010)
        $aturan[] = ['penyakit_id' => $penyakit->where('kode_penyakit', 'P010')->first()->id, 'gejala_id' => $gejala->where('kode_gejala', 'G021')->first()->id, 'bobot' => 0.9]; // Akar membusuk
        $aturan[] = ['penyakit_id' => $penyakit->where('kode_penyakit', 'P010')->first()->id, 'gejala_id' => $gejala->where('kode_gejala', 'G004')->first()->id, 'bobot' => 0.8]; // Daun layu
        $aturan[] = ['penyakit_id' => $penyakit->where('kode_penyakit', 'P010')->first()->id, 'gejala_id' => $gejala->where('kode_gejala', 'G027')->first()->id, 'bobot' => 0.7]; // Pertumbuhan terhambat

        // Aturan untuk Kuning Keriting Virus (P011)
        $aturan[] = ['penyakit_id' => $penyakit->where('kode_penyakit', 'P011')->first()->id, 'gejala_id' => $gejala->where('kode_gejala', 'G001')->first()->id, 'bobot' => 0.8]; // Daun menguning
        $aturan[] = ['penyakit_id' => $penyakit->where('kode_penyakit', 'P011')->first()->id, 'gejala_id' => $gejala->where('kode_gejala', 'G002')->first()->id, 'bobot' => 0.9]; // Daun keriting
        $aturan[] = ['penyakit_id' => $penyakit->where('kode_penyakit', 'P011')->first()->id, 'gejala_id' => $gejala->where('kode_gejala', 'G026')->first()->id, 'bobot' => 0.7]; // Tanaman kerdil

        // Aturan untuk Hawar Daun (P012)
        $aturan[] = ['penyakit_id' => $penyakit->where('kode_penyakit', 'P012')->first()->id, 'gejala_id' => $gejala->where('kode_gejala', 'G003')->first()->id, 'bobot' => 0.8]; // Bercak coklat pada daun
        $aturan[] = ['penyakit_id' => $penyakit->where('kode_penyakit', 'P012')->first()->id, 'gejala_id' => $gejala->where('kode_gejala', 'G007')->first()->id, 'bobot' => 0.7]; // Daun mengering dari ujung
        $aturan[] = ['penyakit_id' => $penyakit->where('kode_penyakit', 'P012')->first()->id, 'gejala_id' => $gejala->where('kode_gejala', 'G010')->first()->id, 'bobot' => 0.6]; // Daun rontok prematur

        // Aturan untuk Busuk Ujung Buah (P013)
        $aturan[] = ['penyakit_id' => $penyakit->where('kode_penyakit', 'P013')->first()->id, 'gejala_id' => $gejala->where('kode_gejala', 'G015')->first()->id, 'bobot' => 0.9]; // Busuk ujung buah
        $aturan[] = ['penyakit_id' => $penyakit->where('kode_penyakit', 'P013')->first()->id, 'gejala_id' => $gejala->where('kode_gejala', 'G014')->first()->id, 'bobot' => 0.6]; // Buah kecil tidak normal
        $aturan[] = ['penyakit_id' => $penyakit->where('kode_penyakit', 'P013')->first()->id, 'gejala_id' => $gejala->where('kode_gejala', 'G013')->first()->id, 'bobot' => 0.5]; // Buah rontok prematur

        // Aturan untuk Nematoda Puru Akar (P014)
        $aturan[] = ['penyakit_id' => $penyakit->where('kode_penyakit', 'P014')->first()->id, 'gejala_id' => $gejala->where('kode_gejala', 'G022')->first()->id, 'bobot' => 0.9]; // Bintil pada akar
        $aturan[] = ['penyakit_id' => $penyakit->where('kode_penyakit', 'P014')->first()->id, 'gejala_id' => $gejala->where('kode_gejala', 'G026')->first()->id, 'bobot' => 0.8]; // Tanaman kerdil
        $aturan[] = ['penyakit_id' => $penyakit->where('kode_penyakit', 'P014')->first()->id, 'gejala_id' => $gejala->where('kode_gejala', 'G027')->first()->id, 'bobot' => 0.7]; // Pertumbuhan terhambat

        // Aturan untuk Klorosis (P015)
        $aturan[] = ['penyakit_id' => $penyakit->where('kode_penyakit', 'P015')->first()->id, 'gejala_id' => $gejala->where('kode_gejala', 'G001')->first()->id, 'bobot' => 0.8]; // Daun menguning
        $aturan[] = ['penyakit_id' => $penyakit->where('kode_penyakit', 'P015')->first()->id, 'gejala_id' => $gejala->where('kode_gejala', 'G029')->first()->id, 'bobot' => 0.7]; // Warna tanaman pucat
        $aturan[] = ['penyakit_id' => $penyakit->where('kode_penyakit', 'P015')->first()->id, 'gejala_id' => $gejala->where('kode_gejala', 'G027')->first()->id, 'bobot' => 0.6]; // Pertumbuhan terhambat

        // Format data untuk insert
        $data = [];
        foreach ($aturan as $item) {
            $data[] = [
                'id' => Uuid::uuid4(),
                'penyakit_id' => $item['penyakit_id'],
                'gejala_id' => $item['gejala_id'],
                'bobot' => $item['bobot'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('aturan_penyakit_gejala')->insert($data);
    }
}
