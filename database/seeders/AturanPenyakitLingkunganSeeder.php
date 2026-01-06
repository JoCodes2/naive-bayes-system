<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;

class AturanPenyakitLingkunganSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // Mapping: [Kode Penyakit => [Nama Parameter => [Kondisi, Bobot]]]
        $rules = [
            'P001' => [ // Antraknosa
                'Kelembapan Udara' => ['tinggi', 0.90],
                'Curah Hujan'      => ['tinggi', 0.85],
            ],
            'P002' => [ // Layu Fusarium
                'pH Tanah'         => ['rendah', 0.90],
                'Kelembapan Tanah' => ['tinggi', 0.70], // Fusarium menyukai tanah lembap-basah
                'Suhu Udara'       => ['tinggi', 0.60],
            ],
            'P003' => [ // Layu Bakteri
                'Kelembapan Udara' => ['tinggi', 0.85],
                'Kelembapan Tanah' => ['tinggi', 0.90], // Bakteri sangat cepat menyebar di tanah basah
                'pH Tanah'         => ['rendah', 0.70],
            ],
            'P004' => [ // Virus Kuning (Bule)
                'Suhu Udara'       => ['tinggi', 0.90],
                'Kelembapan Udara' => ['rendah', 0.70],
            ],
            'P005' => [ // Bercak Daun
                'Kelembapan Udara' => ['tinggi', 0.80],
                'Intensitas Cahaya' => ['rendah', 0.50],
            ],
            'P006' => [ // Hama Thrips
                'Suhu Udara'       => ['tinggi', 0.85],
                'Kelembapan Udara' => ['rendah', 0.80],
                'Kelembapan Tanah' => ['rendah', 0.50], // Thrips berkembang cepat di kondisi kering
            ],
            'P007' => [ // Busuk Phytophthora
                'Curah Hujan'      => ['tinggi', 0.95],
                'Kelembapan Tanah' => ['tinggi', 0.95], // Pemicu utama busuk pangkal batang
                'Kelembapan Udara' => ['tinggi', 0.90],
            ],
            'P008' => [ // Mosaik Virus
                'Suhu Udara'       => ['tinggi', 0.75],
            ],
            'P009' => [ // Embun Tepung
                'Intensitas Cahaya' => ['rendah', 0.95],
                'Kelembapan Udara' => ['tinggi', 0.70],
            ],
            'P010' => [ // Bercak Bakteri
                'Curah Hujan'      => ['tinggi', 0.85],
                'Kelembapan Udara' => ['tinggi', 0.80],
                'Kelembapan Tanah' => ['tinggi', 0.60],
            ],
        ];

        $data = [];

        foreach ($rules as $kodeP => $params) {
            $penyakitId = DB::table('penyakit')->where('kode_penyakit', $kodeP)->value('id');

            foreach ($params as $namaParam => $detail) {
                $parameterId = DB::table('parameter_lingkungan')->where('nama_parameter', $namaParam)->value('id');

                if ($penyakitId && $parameterId) {
                    $data[] = [
                        'id' => Uuid::uuid4()->toString(),
                        'penyakit_id' => $penyakitId,
                        'parameter_id' => $parameterId,
                        'kondisi' => $detail[0],
                        'bobot_pengaruh' => $detail[1],
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
            }
        }

        DB::table('aturan_penyakit_lingkungan')->insert($data);
    }
}
