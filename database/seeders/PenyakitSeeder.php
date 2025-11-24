<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PenyakitSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nama' => 'Busuk Akar', 'deskripsi' => 'Infeksi jamur yang menyebabkan akar membusuk.'],
            ['nama' => 'Embun Tepung', 'deskripsi' => 'Infeksi jamur yang menimbulkan lapisan putih pada daun.'],
            ['nama' => 'Layuan Fusarium', 'deskripsi' => 'Penyakit jamur yang membuat tanaman layu mendadak.'],
            ['nama' => 'Bercak Daun', 'deskripsi' => 'Penyakit yang menimbulkan bercak coklat atau hitam pada daun.'],
            ['nama' => 'Kutu Putih', 'deskripsi' => 'Hama yang meninggalkan lapisan putih seperti kapas.'],
            ['nama' => 'Kutu Daun', 'deskripsi' => 'Koloni serangga kecil yang merusak daun.'],
            ['nama' => 'Busuk Batang', 'deskripsi' => 'Pembusukan pada pangkal atau batang tanaman.'],
            ['nama' => 'Klorosis', 'deskripsi' => 'Daun menguning karena kekurangan nutrisi.'],
            ['nama' => 'Busuk Buah', 'deskripsi' => 'Infeksi jamur yang menyebabkan buah membusuk.'],
            ['nama' => 'Nematoda Akar', 'deskripsi' => 'Cacing mikroskopis yang menyerang akar.'],
        ];

        foreach ($data as $item) {
            DB::table('penyakit')->insert([
                'id' => Str::uuid(),
                'nama' => $item['nama'],
                'deskripsi' => $item['deskripsi'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
