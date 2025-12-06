<?php

namespace App\Interfaces;

use App\Http\Requests\GejalaRequest;
use App\Http\Requests\PenyakitRequest;

interface GejalaInterfaces
{
    public function getAllData();
    public function createData(GejalaRequest $request);
    public function getDataById($id);
    public function updateData(GejalaRequest $request, $id);
    public function deleteData($id);
}
