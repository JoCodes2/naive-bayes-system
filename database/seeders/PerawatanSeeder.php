<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PerawatanSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nama' => 'Fungisida Sistemik', 'jenis' => 'kimia', 'deskripsi' => 'Digunakan untuk jamur penyebab busuk akar dan batang.'],
            ['nama' => 'Neem Oil', 'jenis' => 'organik', 'deskripsi' => 'Minyak alami untuk hama kutu daun dan kutu putih.'],
            ['nama' => 'Pemangkasan Daun Terinfeksi', 'jenis' => 'mekanis', 'deskripsi' => 'Menghilangkan bagian tanaman yang rusak.'],
            ['nama' => 'Ganti Media Tanam', 'jenis' => 'mekanis', 'deskripsi' => 'Mengurangi potensi infeksi ulang pada akar.'],
            ['nama' => 'Pupuk NPK', 'jenis' => 'kimia', 'deskripsi' => 'Mengatasi kekurangan nutrisi tanaman.'],
            ['nama' => 'Pupuk Kompos', 'jenis' => 'organik', 'deskripsi' => 'Menambah unsur hara alami.'],
            ['nama' => 'Solarization Tanah', 'jenis' => 'mekanis', 'deskripsi' => 'Mengendalikan nematoda dengan panas matahari.'],
            ['nama' => 'Insektisida Sistemik', 'jenis' => 'kimia', 'deskripsi' => 'Mengatasi kutu daun dan hama kecil lainnya.'],
            ['nama' => 'Fungisida Tembaga', 'jenis' => 'kimia', 'deskripsi' => 'Efektif untuk bercak daun dan busuk buah.'],
            ['nama' => 'Neem Cake', 'jenis' => 'organik', 'deskripsi' => 'Menghambat perkembangan nematoda di tanah.'],
        ];

        foreach ($data as $item) {
            DB::table('perawatan')->insert([
                'id' => Str::uuid(),
                'nama' => $item['nama'],
                'jenis' => $item['jenis'],
                'deskripsi' => $item['deskripsi'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
