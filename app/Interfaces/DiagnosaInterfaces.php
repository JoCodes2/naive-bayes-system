<?php

namespace App\Interfaces;

use App\Http\Requests\DiagnosaRequest;
use Symfony\Component\HttpFoundation\JsonResponse;

interface DiagnosaInterfaces
{
    public function getMasterData(): JsonResponse;
    public function diagnosa(DiagnosaRequest $request): JsonResponse;
    public function getRiwayat(): JsonResponse;
}
