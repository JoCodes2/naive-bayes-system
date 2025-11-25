<?php

namespace App\Interfaces;

use App\Http\Requests\RekomendasiPencegahanRequest;

interface RekomendasiPencegahanInterfaces
{
    public function getAllData();
    public function createData(RekomendasiPencegahanRequest $request);
    public function getDataById($id);
    public function updateData(RekomendasiPencegahanRequest $request, $id);
    public function deleteData($id);
}
