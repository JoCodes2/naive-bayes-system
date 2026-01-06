<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;

class GejalaSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        $gejala = [
            // KATEGORI: DAUN
            ['kode_gejala' => 'G001', 'deskripsi_gejala' => 'Daun menguning mulai dari bagian bawah', 'kategori' => 'daun'],
            ['kode_gejala' => 'G002', 'deskripsi_gejala' => 'Daun bercak bulat coklat dengan pinggiran kuning', 'kategori' => 'daun'],
            ['kode_gejala' => 'G003', 'deskripsi_gejala' => 'Daun bercak konsentris (seperti target sasaran)', 'kategori' => 'daun'],
            ['kode_gejala' => 'G004', 'deskripsi_gejala' => 'Daun mengkerut, kerdil, dan mosaik', 'kategori' => 'daun'],
            ['kode_gejala' => 'G005', 'deskripsi_gejala' => 'Terdapat lapisan tepung putih pada permukaan daun', 'kategori' => 'daun'],
            ['kode_gejala' => 'G006', 'deskripsi_gejala' => 'Daun layu secara mendadak pada siang hari', 'kategori' => 'daun'],
            ['kode_gejala' => 'G007', 'deskripsi_gejala' => 'Daun berubah warna menjadi kuning terang (klorosis)', 'kategori' => 'daun'],
            ['kode_gejala' => 'G008', 'deskripsi_gejala' => 'Daun mengeriting ke atas dan menguning (bulai)', 'kategori' => 'daun'],
            ['kode_gejala' => 'G009', 'deskripsi_gejala' => 'Tepi daun mengering dan terbakar', 'kategori' => 'daun'],
            ['kode_gejala' => 'G010', 'deskripsi_gejala' => 'Daun berlubang akibat serangan hama pembawa virus', 'kategori' => 'daun'],

            // KATEGORI: BUAH
            ['kode_gejala' => 'G011', 'deskripsi_gejala' => 'Buah busuk dengan bercak cekung melingkar', 'kategori' => 'buah'],
            ['kode_gejala' => 'G012', 'deskripsi_gejala' => 'Ujung buah busuk dan mengering (hitam)', 'kategori' => 'buah'],
            ['kode_gejala' => 'G013', 'deskripsi_gejala' => 'Buah rontok sebelum waktunya', 'kategori' => 'buah'],
            ['kode_gejala' => 'G014', 'deskripsi_gejala' => 'Buah berbentuk kecil dan tidak normal (abnormal)', 'kategori' => 'buah'],
            ['kode_gejala' => 'G015', 'deskripsi_gejala' => 'Bercak basah kecil pada kulit buah', 'kategori' => 'buah'],

            // KATEGORI: BATANG
            ['kode_gejala' => 'G016', 'deskripsi_gejala' => 'Batang membusuk pada pangkal (leher batang)', 'kategori' => 'batang'],
            ['kode_gejala' => 'G017', 'deskripsi_gejala' => 'Batang mengeluarkan lendir saat dipotong', 'kategori' => 'batang'],
            ['kode_gejala' => 'G018', 'deskripsi_gejala' => 'Terdapat bulu halus putih (miselium) pada batang', 'kategori' => 'batang'],
            ['kode_gejala' => 'G019', 'deskripsi_gejala' => 'Batang berubah warna menjadi coklat kehitaman', 'kategori' => 'batang'],

            // KATEGORI: AKAR
            ['kode_gejala' => 'G020', 'deskripsi_gejala' => 'Akar tanaman membusuk dan berbau menyengat', 'kategori' => 'akar'],
            ['kode_gejala' => 'G021', 'deskripsi_gejala' => 'Terdapat bintil-bintil (puru) pada akar', 'kategori' => 'akar'],
            ['kode_gejala' => 'G022', 'deskripsi_gejala' => 'Akar berwarna coklat dan rapuh', 'kategori' => 'akar'],

            // KATEGORI: UMUM
            ['kode_gejala' => 'G023', 'deskripsi_gejala' => 'Tanaman menjadi kerdil (pertumbuhan terhambat)', 'kategori' => 'umum'],
            ['kode_gejala' => 'G024', 'deskripsi_gejala' => 'Tanaman mati mendadak secara menyeluruh', 'kategori' => 'umum'],
            ['kode_gejala' => 'G025', 'deskripsi_gejala' => 'Bunga tanaman rontok massal', 'kategori' => 'umum'],
        ];

        $gejalaWithMeta = array_map(function ($item) use ($now) {
            return array_merge($item, [
                'id' => Uuid::uuid4()->toString(),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }, $gejala);

        DB::table('gejala')->insert($gejalaWithMeta);
    }
}
