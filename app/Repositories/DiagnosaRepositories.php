<?php

namespace App\Repositories;

use App\Interfaces\DiagnosaInterfaces;
use App\Http\Requests\DiagnosaRequest;
use App\Models\{GejalaModel, KondisiLingkunganModel, HasilDiagnosaModel, PenyakitModel};
use App\Services\NaiveBayesService;
use App\Traits\HttpResponseTraits;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\JsonResponse;

class DiagnosaRepositories implements DiagnosaInterfaces
{
    use HttpResponseTraits;
    protected $nbService;

    public function __construct(NaiveBayesService $nbService)
    {
        $this->nbService = $nbService;
    }

    public function getMasterData(): JsonResponse
    {
        $data = [
            'gejala' => GejalaModel::orderBy('kode_gejala', 'asc')->get(),
            'lingkungan' => KondisiLingkunganModel::all()->groupBy('nama_parameter')
        ];
        return $this->success($data);
    }

    public function diagnosa(DiagnosaRequest $request): JsonResponse
    {
        try {
            // 1. Hitung menggunakan Service
            $calculation = $this->nbService->calculate($request->gejala, $request->lingkungan);

            if (empty($calculation)) {
                return $this->error("Data training tidak cukup untuk melakukan diagnosa.");
            }

            $winner = $calculation[0];

            // 2. Gunakan DB Transaction (Opsional tapi disarankan)
            // Agar jika simpan history gagal, response tetap aman
            $diagnosa = HasilDiagnosaModel::create([
                'id' => (string) Str::uuid(),
                'gejala_input' => $request->gejala,
                'lingkungan_input' => $request->lingkungan,
                'penyakit_prediksi' => $winner['penyakit_id'],
                'probabilitas' => round($winner['persentase'], 2), // Simpan angka murni di DB
            ]);

            // 3. Ambil data penyakit dari detail yang sudah ada di $winner
            // Ini lebih cepat daripada query ulang find($id)
            $penyakit = $winner['detail'];

            return $this->success([
                'id_diagnosa' => $diagnosa->id, // Kirim ID history agar FE bisa redirect ke hasil
                'hasil' => $penyakit,
                'keyakinan' => round($winner['persentase'], 2) . '%',
                'detail_perhitungan' => $calculation
            ], "Diagnosa Selesai");
        } catch (\Exception $e) {
            // Gunakan Log untuk tracking error di backend
            Log::error("Diagnosa Error: " . $e->getMessage());
            return $this->error("Terjadi kesalahan pada sistem diagnosa.");
        }
    }

    public function getRiwayat(): JsonResponse
    {
        $data = HasilDiagnosaModel::with('penyakit')->latest()->get();
        return $this->success($data);
    }
}
