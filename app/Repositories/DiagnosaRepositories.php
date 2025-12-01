<?php

namespace App\Repositories;

use App\Http\Requests\DiagnosaRequest;
use App\Interfaces\DiagnosaInterfaces;
use App\Models\GejalaModel;
use App\Models\ParameterLingkunganModel;
use App\Models\RiwayatDiagnosaModel;
use App\Services\DiagnosaService;
use Illuminate\Http\JsonResponse;

class DiagnosaRepositories implements DiagnosaInterfaces
{
    private DiagnosaService $diagnosaService;

    public function __construct(DiagnosaService $diagnosaService)
    {
        $this->diagnosaService = $diagnosaService;
    }

    public function getMasterData(): JsonResponse
    {
        $gejala = GejalaModel::select('id', 'kode_gejala', 'deskripsi_gejala', 'kategori')
            ->orderBy('kategori')
            ->orderBy('kode_gejala')
            ->get();

        $parameter = ParameterLingkunganModel::select('nama_parameter', 'satuan', 'nilai_ideal_min', 'nilai_ideal_max', 'deskripsi')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'gejala' => $gejala,
                'parameter_lingkungan' => $parameter
            ]
        ]);
    }

    public function diagnosa(DiagnosaRequest $request): JsonResponse
    {
        try {
            $kondisiLingkungan = $request->input('kondisi_lingkungan');
            $gejalaDipilih = $request->input('gejala');

            $hasilDiagnosa = $this->diagnosaService->prosesDiagnosa($kondisiLingkungan, $gejalaDipilih);

            $hasilTerbaik = $hasilDiagnosa[0];

            $riwayat = $this->diagnosaService->simpanRiwayat($kondisiLingkungan, $gejalaDipilih, $hasilTerbaik);

            $response = [
                'success' => true,
                'message' => 'Diagnosa berhasil dilakukan',
                'data' => [
                    'diagnosa_terbaik' => [
                        'penyakit' => $hasilTerbaik['penyakit']->nama_penyakit,
                        'kode_penyakit' => $hasilTerbaik['penyakit']->kode_penyakit,
                        'deskripsi' => $hasilTerbaik['penyakit']->deskripsi,
                        'tingkat_kepercayaan' => $hasilTerbaik['persentase'] . '%',
                        'skor_akhir' => $hasilTerbaik['skor_akhir'],
                        'rekomendasi_perawatan' => $hasilTerbaik['penyakit']->solusi_perawatan,
                        'tindakan_pencegahan' => $hasilTerbaik['penyakit']->tindakan_pencegahan,
                        'faktor_risiko' => $hasilTerbaik['penyakit']->faktor_risiko
                    ],
                    'semua_hasil' => collect($hasilDiagnosa)->map(function ($hasil) {
                        return [
                            'penyakit' => $hasil['penyakit']->nama_penyakit,
                            'persentase' => $hasil['persentase'] . '%',
                            'skor_gejala' => $hasil['skor_gejala'],
                            'skor_lingkungan' => $hasil['skor_lingkungan']
                        ];
                    })->toArray(),
                    'riwayat_id' => $riwayat->id
                ]
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat diagnosa: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getRiwayat(): JsonResponse
    {
        $riwayat = RiwayatDiagnosaModel::orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'penyakit_id' => $item->penyakit_id,
                    'tingkat_kepercayaan' => $item->tingkat_kepercayaan . '%',
                    'rekomendasi_perawatan' => $item->rekomendasi_perawatan,
                    'rekomendasi_pencegahan' => $item->rekomendasi_pencegahan,
                    'kondisi_lingkungan' => $item->kondisi_lingkungan,
                    'gejala_yang_dipilih' => $item->gejala_yang_dipilih,
                    'tanggal_diagnosa' => $item->created_at->format('d-m-Y H:i:s'),
                    'catatan_tambahan' => $item->catatan_tambahan
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $riwayat
        ]);
    }
}
