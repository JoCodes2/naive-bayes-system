<?php

namespace App\Services;

use App\Models\DataTrainingModel;
use App\Models\PenyakitModel;

class NaiveBayesService
{
    public function calculate($gejalaInput, $lingkunganInput)
    {
        // Ambil semua data training secara dinamis
        $allTraining = DataTrainingModel::with('penyakit')->get();
        $totalTraining = $allTraining->count();

        // Ambil daftar penyakit yang hanya ada di data training
        $penyakitIds = $allTraining->pluck('penyakit_id')->unique();
        $penyakits = PenyakitModel::whereIn('id', $penyakitIds)->get();

        $results = [];

        foreach ($penyakits as $p) {
            $trainingPenyakit = $allTraining->where('penyakit_id', $p->id);
            $countTrainingPenyakit = $trainingPenyakit->count();

            // --- LANGKAH 1: Prior ---
            $prior = $totalTraining > 0 ? ($countTrainingPenyakit / $totalTraining) : 0;
            $score = $prior;

            // --- LANGKAH 2: Gejala ---
            foreach ($gejalaInput as $gKode) {
                $countGejala = $trainingPenyakit->filter(function ($item) use ($gKode) {
                    $gejalaData = is_array($item->gejala) ? $item->gejala : json_decode($item->gejala, true);
                    return in_array($gKode, (array)$gejalaData);
                })->count();

                // Laplace Smoothing: 0.2 jika tidak ditemukan
                $prob = ($countGejala > 0) ? ($countGejala / $countTrainingPenyakit) : 0.2;
                $score *= $prob;
            }

            // --- LANGKAH 3: Lingkungan ---
            foreach ($lingkunganInput as $param => $label) {
                $countLingkungan = $trainingPenyakit->filter(function ($item) use ($param, $label) {
                    $lingkunganData = is_array($item->lingkungan) ? $item->lingkungan : json_decode($item->lingkungan, true);
                    return isset($lingkunganData[$param]) && $lingkunganData[$param] === $label;
                })->count();

                $prob = ($countLingkungan > 0) ? ($countLingkungan / $countTrainingPenyakit) : 0.2;
                $score *= $prob;
            }

            $results[] = [
                'penyakit_id'   => $p->id,
                'kode_penyakit' => $p->kode_penyakit,
                'nama_penyakit' => $p->nama_penyakit,
                'score'         => $score,
                'detail'        => $p
            ];
        }

        // --- LANGKAH 4: Normalisasi (Persentase) ---
        $totalScore = array_sum(array_column($results, 'score'));
        foreach ($results as &$res) {
            $res['persentase'] = $totalScore > 0 ? ($res['score'] / $totalScore) * 100 : 0;
        }

        // Urutkan berdasarkan score tertinggi
        usort($results, fn($a, $b) => $b['score'] <=> $a['score']);

        return $results;
    }
}
