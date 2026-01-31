<?php

namespace App\Services;

use App\Models\DataTrainingModel;
use App\Models\PenyakitModel;
use App\Models\GejalaModel;

class NaiveBayesService
{
    public function calculate($gejalaInput, $lingkunganInput)
    {
        // 1. Persiapan Data Master
        $penyakits = PenyakitModel::all();
        $allTraining = DataTrainingModel::all();
        $totalTraining = $allTraining->count();

        // Ambil total variasi gejala dari DB untuk pembagi Laplace (misal ada 25 gejala)
        $totalVariasiGejala = GejalaModel::count() ?: 25;
        $totalVariasiLingkungan = 3; // rendah, normal, tinggi

        $results = [];

        // Jika input kosong, kembalikan array kosong agar tidak salah diagnosa
        if (empty($gejalaInput) && empty($lingkunganInput)) {
            return [];
        }

        foreach ($penyakits as $p) {
            // Filter data training milik penyakit ini
            $trainingPenyakit = $allTraining->where('penyakit_id', $p->id);
            $countTrainingPenyakit = $trainingPenyakit->count();

            // --- 1. Prior Probability P(Ci) ---
            // Rumus: (Total Kasus Penyakit i + 1) / (Total Semua Kasus + Jumlah Jenis Penyakit)
            $prior = ($countTrainingPenyakit + 1) / ($totalTraining + $penyakits->count());

            // --- 2. Likelihood Gejala P(X|Ci) ---
            $likelihoodGejala = 1.0;
            if (!empty($gejalaInput)) {
                foreach ($gejalaInput as $gKode) {
                    $countGejalaMuncul = $trainingPenyakit->filter(function ($item) use ($gKode) {
                        $gejalaData = is_array($item->gejala) ? $item->gejala : json_decode($item->gejala, true);
                        return in_array($gKode, (array)$gejalaData);
                    })->count();

                    // Laplace Smoothing: (Muncul + 1) / (Total Kasus Penyakit + Total Variasi Gejala)
                    $likelihoodGejala *= ($countGejalaMuncul + 1) / ($countTrainingPenyakit + $totalVariasiGejala);
                }
            }

            // --- 3. Likelihood Lingkungan P(L|Ci) ---
            $likelihoodLingkungan = 1.0;
            if (!empty($lingkunganInput)) {
                foreach ($lingkunganInput as $parameter => $label) {
                    $countLingkunganMuncul = $trainingPenyakit->filter(function ($item) use ($parameter, $label) {
                        $lingkunganData = is_array($item->lingkungan) ? $item->lingkungan : json_decode($item->lingkungan, true);
                        return isset($lingkunganData[$parameter]) && $lingkunganData[$parameter] === $label;
                    })->count();

                    // Laplace Smoothing: (Cocok + 1) / (Total Kasus Penyakit + 3)
                    $likelihoodLingkungan *= ($countLingkunganMuncul + 1) / ($countTrainingPenyakit + $totalVariasiLingkungan);
                }
            }

            // --- 4. Skor Akhir (Posterior) ---
            $finalScore = $prior * $likelihoodGejala * $likelihoodLingkungan;

            $results[] = [
                'penyakit_id' => $p->id,
                'nama_penyakit' => $p->nama_penyakit,
                'score' => $finalScore,
                'detail' => $p
            ];
        }

        // --- 5. Normalisasi ke Persentase ---
        $totalScore = array_sum(array_column($results, 'score'));

        foreach ($results as &$res) {
            // Jika totalScore > 0, hitung persentase. Jika tidak, beri 0.
            $res['persentase'] = $totalScore > 0 ? ($res['score'] / $totalScore) * 100 : 0;
        }

        // Urutkan dari skor tertinggi (Juara) ke terendah
        usort($results, fn($a, $b) => $b['score'] <=> $a['score']);

        return $results;
    }
}
