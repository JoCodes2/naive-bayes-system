<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;

class AturanPenyakitGejalaSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // Pemetaan yang disesuaikan dengan 10 Penyakit (P001-P010)
        // dan Gejala (G001-G025)
        $rules = [
            // P001: Antraknosa (Patek) -> Fokus pada Buah
            'P001' => ['G011' => 0.95, 'G013' => 0.60, 'G025' => 0.40],

            // P002: Layu Fusarium -> Fokus pada Layu & Kuning Bawah
            'P002' => ['G001' => 0.85, 'G006' => 0.90, 'G024' => 0.70],

            // P003: Layu Bakteri -> Fokus pada Layu & Lendir Batang
            'P003' => ['G006' => 0.95, 'G017' => 0.98, 'G024' => 0.80],

            // P004: Virus Kuning (Bule) -> Fokus pada Warna Kuning & Keriting
            'P004' => ['G008' => 0.98, 'G007' => 0.90, 'G023' => 0.80],

            // P005: Bercak Daun (Cercospora) -> Fokus pada Bercak Bulat
            'P005' => ['G002' => 0.90, 'G013' => 0.30],

            // P006: Hama Thrips (Keriting Daun) -> Fokus pada Keriting & Berlubang
            'P006' => ['G008' => 0.90, 'G010' => 0.85, 'G023' => 0.60],

            // P007: Busuk Phytophthora -> Fokus pada Batang Hitam & Busuk Basah
            'P007' => ['G016' => 0.95, 'G019' => 0.90, 'G011' => 0.50],

            // P008: Mosaik Virus -> Fokus pada Corak Mosaik & Buah Abnormal
            'P008' => ['G004' => 0.95, 'G014' => 0.85, 'G023' => 0.70],

            // P009: Embun Tepung -> Fokus pada Lapisan Putih
            'P009' => ['G005' => 0.98, 'G001' => 0.40],

            // P010: Bercak Bakteri -> Fokus pada Bercak Basah & Kasar
            'P010' => ['G015' => 0.90, 'G002' => 0.70, 'G011' => 0.40],
        ];

        $dataAturan = [];

        foreach ($rules as $kodeP => $gejalas) {
            $penyakitId = DB::table('penyakit')->where('kode_penyakit', $kodeP)->value('id');

            foreach ($gejalas as $kodeG => $bobot) {
                $gejalaId = DB::table('gejala')->where('kode_gejala', $kodeG)->value('id');

                if ($penyakitId && $gejalaId) {
                    $dataAturan[] = [
                        'id' => Uuid::uuid4()->toString(),
                        'penyakit_id' => $penyakitId,
                        'gejala_id' => $gejalaId,
                        'bobot' => $bobot,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
            }
        }

        DB::table('aturan_penyakit_gejala')->insert($dataAturan);
    }
}
