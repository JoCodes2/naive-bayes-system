<?php
// database/seeders/AturanPenyakitLingkunganSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class AturanPenyakitLingkunganSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua penyakit dan parameter
        $penyakit = DB::table('penyakit')->get();
        $parameter = DB::table('parameter_lingkungan')->get();

        $aturan = [];

        // Fungsi helper untuk mendapatkan ID
        $getPenyakitId = function ($kode) use ($penyakit) {
            return $penyakit->where('kode_penyakit', $kode)->first()->id;
        };

        $getParameterId = function ($nama) use ($parameter) {
            return $parameter->where('nama_parameter', $nama)->first()->id;
        };

        // Aturan lingkungan untuk berbagai penyakit
        // Antraknosa - suhu tinggi & kelembapan tinggi
        $aturan[] = ['penyakit_id' => $getPenyakitId('P001'), 'parameter_id' => $getParameterId('Suhu Udara'), 'kondisi' => 'tinggi', 'bobot_pengaruh' => 0.7];
        $aturan[] = ['penyakit_id' => $getPenyakitId('P001'), 'parameter_id' => $getParameterId('Kelembapan Udara'), 'kondisi' => 'tinggi', 'bobot_pengaruh' => 0.8];
        $aturan[] = ['penyakit_id' => $getPenyakitId('P001'), 'parameter_id' => $getParameterId('Curah Hujan'), 'kondisi' => 'tinggi', 'bobot_pengaruh' => 0.6];

        // Layu Fusarium - tanah asam & drainase buruk
        $aturan[] = ['penyakit_id' => $getPenyakitId('P002'), 'parameter_id' => $getParameterId('pH Tanah'), 'kondisi' => 'rendah', 'bobot_pengaruh' => 0.8];
        $aturan[] = ['penyakit_id' => $getPenyakitId('P002'), 'parameter_id' => $getParameterId('Kelembapan Tanah'), 'kondisi' => 'tinggi', 'bobot_pengaruh' => 0.7];

        // Bercak Daun Cercospora - kelembapan tinggi
        $aturan[] = ['penyakit_id' => $getPenyakitId('P003'), 'parameter_id' => $getParameterId('Kelembapan Udara'), 'kondisi' => 'tinggi', 'bobot_pengaruh' => 0.8];
        $aturan[] = ['penyakit_id' => $getPenyakitId('P003'), 'parameter_id' => $getParameterId('Curah Hujan'), 'kondisi' => 'tinggi', 'bobot_pengaruh' => 0.6];

        // Busuk Daun Phytophthora - genangan air
        $aturan[] = ['penyakit_id' => $getPenyakitId('P004'), 'parameter_id' => $getParameterId('Kelembapan Tanah'), 'kondisi' => 'tinggi', 'bobot_pengaruh' => 0.9];
        $aturan[] = ['penyakit_id' => $getPenyakitId('P004'), 'parameter_id' => $getParameterId('Curah Hujan'), 'kondisi' => 'tinggi', 'bobot_pengaruh' => 0.7];

        // Embun Tepung - kelembapan tinggi & cahaya rendah
        $aturan[] = ['penyakit_id' => $getPenyakitId('P007'), 'parameter_id' => $getParameterId('Kelembapan Udara'), 'kondisi' => 'tinggi', 'bobot_pengaruh' => 0.7];
        $aturan[] = ['penyakit_id' => $getPenyakitId('P007'), 'parameter_id' => $getParameterId('Intensitas Cahaya'), 'kondisi' => 'rendah', 'bobot_pengaruh' => 0.6];

        // Layu Bakteri - suhu tinggi & tanah asam
        $aturan[] = ['penyakit_id' => $getPenyakitId('P008'), 'parameter_id' => $getParameterId('Suhu Udara'), 'kondisi' => 'tinggi', 'bobot_pengaruh' => 0.7];
        $aturan[] = ['penyakit_id' => $getPenyakitId('P008'), 'parameter_id' => $getParameterId('pH Tanah'), 'kondisi' => 'rendah', 'bobot_pengaruh' => 0.6];

        // Bercak Bakteri - curah hujan tinggi & angin
        $aturan[] = ['penyakit_id' => $getPenyakitId('P009'), 'parameter_id' => $getParameterId('Curah Hujan'), 'kondisi' => 'tinggi', 'bobot_pengaruh' => 0.8];

        // Busuk Akar - drainase buruk
        $aturan[] = ['penyakit_id' => $getPenyakitId('P010'), 'parameter_id' => $getParameterId('Kelembapan Tanah'), 'kondisi' => 'tinggi', 'bobot_pengaruh' => 0.9];

        // Klorosis - pH tanah tidak optimal
        $aturan[] = ['penyakit_id' => $getPenyakitId('P015'), 'parameter_id' => $getParameterId('pH Tanah'), 'kondisi' => 'rendah', 'bobot_pengaruh' => 0.8];
        $aturan[] = ['penyakit_id' => $getPenyakitId('P015'), 'parameter_id' => $getParameterId('Kelembapan Tanah'), 'kondisi' => 'tinggi', 'bobot_pengaruh' => 0.5];

        // Format data untuk insert
        $data = [];
        foreach ($aturan as $item) {
            $data[] = [
                'id' => Uuid::uuid4(),
                'penyakit_id' => $item['penyakit_id'],
                'parameter_id' => $item['parameter_id'],
                'kondisi' => $item['kondisi'],
                'bobot_pengaruh' => $item['bobot_pengaruh'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('aturan_penyakit_lingkungan')->insert($data);
    }
}
