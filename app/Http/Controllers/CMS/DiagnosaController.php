<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;

use App\Http\Requests\DiagnosaRequest;
use App\Interfaces\DiagnosaInterfaces;
use App\Repositories\DiagnosaRepositories;
use Illuminate\Http\JsonResponse;

class DiagnosaController extends Controller
{
    protected $diagnosaRepository;

    public function __construct(DiagnosaRepositories $diagnosaRepository)
    {
        $this->diagnosaRepository = $diagnosaRepository;
    }

    /**
     * Get data master untuk form diagnosa
     */
    public function getMasterData(): JsonResponse
    {
        return $this->diagnosaRepository->getMasterData();
    }

    /**
     * Proses diagnosa penyakit
     */
    public function diagnosa(DiagnosaRequest $request): JsonResponse
    {
        return $this->diagnosaRepository->diagnosa($request);
    }

    /**
     * Get riwayat diagnosa
     */
    public function getRiwayat(): JsonResponse
    {
        return $this->diagnosaRepository->getRiwayat();
    }
}
