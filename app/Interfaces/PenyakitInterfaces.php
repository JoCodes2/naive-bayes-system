<?php

namespace App\Interfaces;

use App\Http\Requests\PenyakitRequest;

interface PenyakitInterfaces
{
    public function getAllData();
    public function createData(PenyakitRequest $request);
    public function getDataById($id);
    public function updateData(PenyakitRequest $request, $id);
    public function deleteData($id);
}
