<?php

namespace App\Services;

use App\Models\PenyakitModel;
use App\Models\RiwayatDiagnosaModel;
use Illuminate\Support\Facades\DB;

class DiagnosaService
{
    /**
     * Melakukan proses diagnosa berdasarkan gejala dan kondisi lingkungan.
     */
    public function prosesDiagnosa(array $kondisiLingkungan, array $gejalaDipilih): array
    {
        // Eager loading 'parameter' untuk menghindari N+1 query pada skor lingkungan
        $semuaPenyakit = PenyakitModel::with(['aturanGejala', 'aturanLingkungan.parameter'])->get();
        $hasilDiagnosa = [];

        foreach ($semuaPenyakit as $penyakit) {
            $skorGejala = $this->hitungSkorGejala($penyakit, $gejalaDipilih);
            $skorLingkungan = $this->hitungSkorLingkungan($penyakit, $kondisiLingkungan);

            // Perhitungan skor akhir dengan bobot 70:30
            $skorAkhir = ($skorGejala * 0.7) + ($skorLingkungan * 0.3);

            $hasilDiagnosa[] = [
                'penyakit' => $penyakit,
                'skor_gejala' => $skorGejala,
                'skor_lingkungan' => $skorLingkungan,
                'skor_akhir' => $skorAkhir,
                'persentase' => round($skorAkhir * 100, 2)
            ];
        }

        // Urutkan berdasarkan skor tertinggi
        usort($hasilDiagnosa, fn($a, $b) => $b['skor_akhir'] <=> $a['skor_akhir']);

        return $hasilDiagnosa;
    }

    private function hitungSkorGejala(PenyakitModel $penyakit, array $gejalaDipilih): float
    {
        $totalBobot = 0;
        $skor = 0;

        foreach ($penyakit->aturanGejala as $aturan) {
            if (in_array($aturan->gejala_id, $gejalaDipilih)) {
                $skor += (float) $aturan->bobot;
            }
            $totalBobot += (float) $aturan->bobot;
        }

        return $totalBobot > 0 ? $skor / $totalBobot : 0;
    }

    private function hitungSkorLingkungan(PenyakitModel $penyakit, array $kondisiLingkungan): float
    {
        $totalBobot = 0;
        $skor = 0;

        foreach ($penyakit->aturanLingkungan as $aturan) {
            $parameterModel = $aturan->parameter; // Mengambil data dari eager load
            if (!$parameterModel) continue;

            $key = $this->convertToSnakeCase($parameterModel->nama_parameter);
            $nilaiInput = $kondisiLingkungan[$key] ?? null;

            // Pastikan nilaiInput tidak null sebelum mencocokkan kondisi
            if ($nilaiInput !== null && $this->cocokKondisiLingkungan($nilaiInput, $aturan->kondisi, $parameterModel)) {
                $skor += (float) $aturan->bobot_pengaruh;
            }
            $totalBobot += (float) $aturan->bobot_pengaruh;
        }

        return $totalBobot > 0 ? $skor / $totalBobot : 0;
    }

    private function cocokKondisiLingkungan($nilaiInput, string $kondisi, $param): bool
    {
        $minIdeal = (float) $param->nilai_ideal_min;
        $maxIdeal = (float) $param->nilai_ideal_max;

        switch ($kondisi) {
            case 'tinggi':
                return $nilaiInput > $maxIdeal;
            case 'rendah':
                return $nilaiInput < $minIdeal;
            case 'normal': // Sesuai dengan data Seeder Anda
                return $nilaiInput >= $minIdeal && $nilaiInput <= $maxIdeal;
            default:
                return false;
        }
    }

    private function convertToSnakeCase(string $text): string
    {
        return strtolower(str_replace(' ', '_', $text));
    }

    public function simpanRiwayat(array $kondisiLingkungan, array $gejalaDipilih, array $hasilTerbaik): RiwayatDiagnosaModel
    {
        return RiwayatDiagnosaModel::create([
            'kondisi_lingkungan' => $kondisiLingkungan,
            'gejala_yang_dipilih' => $gejalaDipilih,
            'penyakit_id' => $hasilTerbaik['penyakit']->id,
            'tingkat_kepercayaan' => $hasilTerbaik['persentase'],
            'rekomendasi_perawatan' => $hasilTerbaik['penyakit']->solusi_perawatan,
            'rekomendasi_pencegahan' => $hasilTerbaik['penyakit']->tindakan_pencegahan,
            'catatan_tambahan' => "Diagnosa otomatis: " . $hasilTerbaik['penyakit']->nama_penyakit . " dengan keyakinan " . $hasilTerbaik['persentase'] . "%"
        ]);
    }
}
