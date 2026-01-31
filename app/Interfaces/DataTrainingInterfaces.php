<?php

namespace App\Interfaces;

use App\Http\Requests\DataTrainingRequest;

interface DataTrainingInterfaces
{
    public function getAllData();
    public function createData(DataTrainingRequest $request);
    public function getDataById($id);
    public function updateData(DataTrainingRequest $request, $id);
    public function deleteData($id);
}
