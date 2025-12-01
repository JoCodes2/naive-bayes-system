<?php
// app/Services/DiagnosaService.php

namespace App\Services;

use App\Models\Penyakit;
use App\Models\Gejala;
use App\Models\ParameterLingkungan;
use App\Models\ParameterLingkunganModel;
use App\Models\PenyakitModel;
use App\Models\RiwayatDiagnosa;
use App\Models\RiwayatDiagnosaModel;
use Illuminate\Support\Collection;

class DiagnosaService
{
    public function prosesDiagnosa(array $kondisiLingkungan, array $gejalaDipilih): array
    {
        $semuaPenyakit = PenyakitModel::with(['aturanGejala', 'aturanLingkungan.parameter'])->get();
        $hasilDiagnosa = [];

        foreach ($semuaPenyakit as $penyakit) {
            $skorGejala = $this->hitungSkorGejala($penyakit, $gejalaDipilih);
            $skorLingkungan = $this->hitungSkorLingkungan($penyakit, $kondisiLingkungan);


            $skorAkhir = ($skorGejala * 0.7) + ($skorLingkungan * 0.3);

            $hasilDiagnosa[] = [
                'penyakit' => $penyakit,
                'skor_gejala' => $skorGejala,
                'skor_lingkungan' => $skorLingkungan,
                'skor_akhir' => $skorAkhir,
                'persentase' => round($skorAkhir * 100, 2)
            ];
        }
        usort($hasilDiagnosa, function ($a, $b) {
            return $b['skor_akhir'] <=> $a['skor_akhir'];
        });

        return $hasilDiagnosa;
    }

    private function hitungSkorGejala(PenyakitModel $penyakit, array $gejalaDipilih): float
    {
        $totalBobot = 0;
        $skor = 0;

        foreach ($penyakit->aturanGejala as $aturan) {
            if (in_array($aturan->gejala_id, $gejalaDipilih)) {
                $skor += $aturan->bobot;
            }
            $totalBobot += $aturan->bobot;
        }

        return $totalBobot > 0 ? $skor / $totalBobot : 0;
    }

    private function hitungSkorLingkungan(PenyakitModel $penyakit, array $kondisiLingkungan): float
    {
        $totalBobot = 0;
        $skor = 0;

        foreach ($penyakit->aturanLingkungan as $aturan) {
            $parameter = $aturan->parameter->nama_parameter;
            $nilaiInput = $kondisiLingkungan[$this->convertToSnakeCase($parameter)] ?? null;

            if ($nilaiInput && $this->cocokKondisiLingkungan($nilaiInput, $aturan->kondisi, $parameter)) {
                $skor += $aturan->bobot_pengaruh;
            }
            $totalBobot += $aturan->bobot_pengaruh;
        }

        return $totalBobot > 0 ? $skor / $totalBobot : 0;
    }

    private function convertToSnakeCase(string $text): string
    {
        return strtolower(str_replace(' ', '_', $text));
    }

    private function cocokKondisiLingkungan($nilaiInput, string $kondisi, string $parameter): bool
    {

        $param = ParameterLingkunganModel::where('nama_parameter', $parameter)->first();

        if (!$param) return false;

        $minIdeal = $param->nilai_ideal_min;
        $maxIdeal = $param->nilai_ideal_max;

        switch ($kondisi) {
            case 'tinggi':
                return $nilaiInput > $maxIdeal;
            case 'rendah':
                return $nilaiInput < $minIdeal;
            case 'optimal':
                return $nilaiInput >= $minIdeal && $nilaiInput <= $maxIdeal;
            default:
                return false;
        }
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
            'catatan_tambahan' => "Diagnosa berdasarkan analisis gejala dan kondisi lingkungan dengan tingkat kepercayaan {$hasilTerbaik['persentase']}%"
        ]);
    }
}
