<?php

namespace App\Interfaces;

use App\Http\Requests\ParameterRequest;

interface ParameterInterfaces
{
    public function getAllData();
    public function createData(ParameterRequest $request);
    public function getDataById($id);
    public function updateData(ParameterRequest $request, $id);
    public function deleteData($id);
}
