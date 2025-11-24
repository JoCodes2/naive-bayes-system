<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RekomendasiPencegahanSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['judul' => 'Hindari Penyiraman Berlebihan', 'deskripsi' => 'Mencegah busuk akar dan busuk batang.'],
            ['judul' => 'Gunakan Media Tanam Steril', 'deskripsi' => 'Mencegah infeksi jamur dan nematoda.'],
            ['judul' => 'Sirkulasi Udara yang Baik', 'deskripsi' => 'Mengurangi risiko embun tepung.'],
            ['judul' => 'Isolasi Tanaman Baru', 'deskripsi' => 'Menghindari penularan hama ke tanaman lain.'],
            ['judul' => 'Pemupukan Teratur', 'deskripsi' => 'Mencegah klorosis dan kekurangan nutrisi.'],
            ['judul' => 'Jangan Menyiram Daun Langsung', 'deskripsi' => 'Menghindari bercak daun jamur.'],
            ['judul' => 'Periksa Tanaman Setiap Minggu', 'deskripsi' => 'Deteksi dini hama kutu putih dan kutu daun.'],
            ['judul' => 'Gunakan Pot dengan Drainase Baik', 'deskripsi' => 'Menghindari genangan air di akar.'],
            ['judul' => 'Rotasi Tanaman', 'deskripsi' => 'Mencegah penyakit tanah seperti fusarium.'],
            ['judul' => 'Jaga Kebersihan Lingkungan Tanaman', 'deskripsi' => 'Mengurangi risiko berkembangnya penyakit.'],
        ];

        foreach ($data as $item) {
            DB::table('rekomendasi_pencegahan')->insert([
                'id' => Str::uuid(),
                'judul' => $item['judul'],
                'deskripsi' => $item['deskripsi'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
