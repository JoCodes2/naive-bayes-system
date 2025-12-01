<?php
// database/seeders/GejalaSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class GejalaSeeder extends Seeder
{
    public function run(): void
    {
        $gejala = [
            // Gejala pada Daun (10 gejala)
            ['id' => Uuid::uuid4(), 'kode_gejala' => 'G001', 'deskripsi_gejala' => 'Daun menguning', 'kategori' => 'daun'],
            ['id' => Uuid::uuid4(), 'kode_gejala' => 'G002', 'deskripsi_gejala' => 'Daun keriting', 'kategori' => 'daun'],
            ['id' => Uuid::uuid4(), 'kode_gejala' => 'G003', 'deskripsi_gejala' => 'Bercak coklat pada daun', 'kategori' => 'daun'],
            ['id' => Uuid::uuid4(), 'kode_gejala' => 'G004', 'deskripsi_gejala' => 'Daun layu', 'kategori' => 'daun'],
            ['id' => Uuid::uuid4(), 'kode_gejala' => 'G005', 'deskripsi_gejala' => 'Bercak hitam pada daun', 'kategori' => 'daun'],
            ['id' => Uuid::uuid4(), 'kode_gejala' => 'G006', 'deskripsi_gejala' => 'Lapisan tepung putih pada daun', 'kategori' => 'daun'],
            ['id' => Uuid::uuid4(), 'kode_gejala' => 'G007', 'deskripsi_gejala' => 'Daun mengering dari ujung', 'kategori' => 'daun'],
            ['id' => Uuid::uuid4(), 'kode_gejala' => 'G008', 'deskripsi_gejala' => 'Pertumbuhan daun abnormal', 'kategori' => 'daun'],
            ['id' => Uuid::uuid4(), 'kode_gejala' => 'G009', 'deskripsi_gejala' => 'Daun berlubang', 'kategori' => 'daun'],
            ['id' => Uuid::uuid4(), 'kode_gejala' => 'G010', 'deskripsi_gejala' => 'Daun rontok prematur', 'kategori' => 'daun'],

            // Gejala pada Buah (5 gejala)
            ['id' => Uuid::uuid4(), 'kode_gejala' => 'G011', 'deskripsi_gejala' => 'Buah busuk', 'kategori' => 'buah'],
            ['id' => Uuid::uuid4(), 'kode_gejala' => 'G012', 'deskripsi_gejala' => 'Bercak pada buah', 'kategori' => 'buah'],
            ['id' => Uuid::uuid4(), 'kode_gejala' => 'G013', 'deskripsi_gejala' => 'Buah rontok prematur', 'kategori' => 'buah'],
            ['id' => Uuid::uuid4(), 'kode_gejala' => 'G014', 'deskripsi_gejala' => 'Buah kecil tidak normal', 'kategori' => 'buah'],
            ['id' => Uuid::uuid4(), 'kode_gejala' => 'G015', 'deskripsi_gejala' => 'Busuk ujung buah', 'kategori' => 'buah'],

            // Gejala pada Batang (5 gejala)
            ['id' => Uuid::uuid4(), 'kode_gejala' => 'G016', 'deskripsi_gejala' => 'Batang busuk', 'kategori' => 'batang'],
            ['id' => Uuid::uuid4(), 'kode_gejala' => 'G017', 'deskripsi_gejala' => 'Batang keropos', 'kategori' => 'batang'],
            ['id' => Uuid::uuid4(), 'kode_gejala' => 'G018', 'deskripsi_gejala' => 'Lendir pada batang', 'kategori' => 'batang'],
            ['id' => Uuid::uuid4(), 'kode_gejala' => 'G019', 'deskripsi_gejala' => 'Pertumbuhan batang terhambat', 'kategori' => 'batang'],
            ['id' => Uuid::uuid4(), 'kode_gejala' => 'G020', 'deskripsi_gejala' => 'Bengkak pada batang', 'kategori' => 'batang'],

            // Gejala pada Akar (5 gejala)
            ['id' => Uuid::uuid4(), 'kode_gejala' => 'G021', 'deskripsi_gejala' => 'Akar membusuk', 'kategori' => 'akar'],
            ['id' => Uuid::uuid4(), 'kode_gejala' => 'G022', 'deskripsi_gejala' => 'Bintil pada akar', 'kategori' => 'akar'],
            ['id' => Uuid::uuid4(), 'kode_gejala' => 'G023', 'deskripsi_gejala' => 'Pertumbuhan akar terhambat', 'kategori' => 'akar'],
            ['id' => Uuid::uuid4(), 'kode_gejala' => 'G024', 'deskripsi_gejala' => 'Akar berwarna coklat', 'kategori' => 'akar'],
            ['id' => Uuid::uuid4(), 'kode_gejala' => 'G025', 'deskripsi_gejala' => 'Sistem akar tidak berkembang', 'kategori' => 'akar'],

            // Gejala Umum (5 gejala)
            ['id' => Uuid::uuid4(), 'kode_gejala' => 'G026', 'deskripsi_gejala' => 'Tanaman kerdil', 'kategori' => 'umum'],
            ['id' => Uuid::uuid4(), 'kode_gejala' => 'G027', 'deskripsi_gejala' => 'Pertumbuhan terhambat', 'kategori' => 'umum'],
            ['id' => Uuid::uuid4(), 'kode_gejala' => 'G028', 'deskripsi_gejala' => 'Produksi buah menurun', 'kategori' => 'umum'],
            ['id' => Uuid::uuid4(), 'kode_gejala' => 'G029', 'deskripsi_gejala' => 'Warna tanaman pucat', 'kategori' => 'umum'],
            ['id' => Uuid::uuid4(), 'kode_gejala' => 'G030', 'deskripsi_gejala' => 'Tanaman mudah layu', 'kategori' => 'umum'],
        ];

        DB::table('gejala')->insert($gejala);
    }
}
