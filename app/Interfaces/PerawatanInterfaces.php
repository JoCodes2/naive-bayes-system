<?php

namespace App\Interfaces;

use App\Http\Requests\PerawatanRequest;

interface PerawatanInterfaces
{
    public function getAllData();
    public function createData(PerawatanRequest $request);
    public function getDataById($id);
    public function updateData(PerawatanRequest $request, $id);
    public function deleteData($id);
}
