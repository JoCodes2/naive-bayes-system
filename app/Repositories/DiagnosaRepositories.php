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
            $calculation = $this->nbService->calculate($request->gejala, $request->lingkungan);

            if (empty($calculation)) {
                return $this->error("Data training tidak cukup untuk melakukan diagnosa.");
            }

            $winner = $calculation[0];

            $diagnosa = HasilDiagnosaModel::create([
                'id' => (string) Str::uuid(),
                'nama_petani' => $request->nama_petani,
                'gejala_input' => $request->gejala,
                'lingkungan_input' => $request->lingkungan,
                'penyakit_prediksi' => $winner['penyakit_id'],
                'probabilitas' => round($winner['persentase'], 2),
            ]);

            $penyakit = $winner['detail'];

            return $this->success([
                'id_diagnosa' => $diagnosa->id,
                'data' => $diagnosa,
                'hasil' => $penyakit,
                'keyakinan' => round($winner['persentase'], 2) . '%',
                'detail_perhitungan' => $calculation,
            ], "Diagnosa Selesai");
        } catch (\Exception $e) {
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
