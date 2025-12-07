<?php

namespace App\Interfaces;

use App\Http\Requests\AturanGejalaRequest;

interface AturanGejalaInterfaces
{
    public function getAllData();
    // public function getkode();
    public function createData(AturanGejalaRequest $request);
    public function getDataById($id);
    public function updateData(AturanGejalaRequest $request, $id);
    public function deleteData($id);
}
