<?php

namespace App\Interfaces;

use App\Http\Requests\AturanPenyakitLingkunganRequest;

interface AturanPenyakitLingkunganInterfaces
{
    public function getAllData();
    public function createData(AturanPenyakitLingkunganRequest $request);
    public function getDataById($id);
    public function updateData(AturanPenyakitLingkunganRequest $request, $id);
    public function deleteData($id);
}
