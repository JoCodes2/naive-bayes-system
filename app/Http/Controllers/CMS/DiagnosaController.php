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
    public function getMasterData(): JsonResponse
    {
        return $this->diagnosaRepository->getMasterData();
    }

    public function diagnosa(DiagnosaRequest $request): JsonResponse
    {
        return $this->diagnosaRepository->diagnosa($request);
    }

    public function getRiwayat(): JsonResponse
    {
        return $this->diagnosaRepository->getRiwayat();
    }
}
