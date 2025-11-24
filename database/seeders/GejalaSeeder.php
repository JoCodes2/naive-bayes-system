<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GejalaSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nama' => 'Akar berwarna coklat kehitaman', 'deskripsi' => 'Akar berubah warna dan lembek akibat infeksi jamur.'],
            ['nama' => 'Daun menguning', 'deskripsi' => 'Daun berubah warna menjadi kuning dan mudah rontok.'],
            ['nama' => 'Tanaman layu meski tanah basah', 'deskripsi' => 'Kondisi tanaman tetap layu walau media tidak kering.'],
            ['nama' => 'Bintik putih seperti tepung', 'deskripsi' => 'Gejala khas embun tepung pada daun.'],
            ['nama' => 'Daun menggulung', 'deskripsi' => 'Daun berubah bentuk karena infeksi atau hama.'],
            ['nama' => 'Batang bagian bawah menghitam', 'deskripsi' => 'Penyakit busuk batang yang menyerang pangkal tanaman.'],
            ['nama' => 'Daun keriting', 'deskripsi' => 'Kerusakan daun akibat hama kutu daun.'],
            ['nama' => 'Bercak hitam pada daun', 'deskripsi' => 'Bercak gelap yang tampak menyebar pada daun.'],
            ['nama' => 'Pembengkakan pada akar', 'deskripsi' => 'Akar membesar akibat serangan nematoda.'],
            ['nama' => 'Daun pucat', 'deskripsi' => 'Kekurangan nutrisi atau gangguan akar menyebabkan daun memudar.'],
        ];

        foreach ($data as $item) {
            DB::table('gejala')->insert([
                'id' => Str::uuid(),
                'nama' => $item['nama'],
                'deskripsi' => $item['deskripsi'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
