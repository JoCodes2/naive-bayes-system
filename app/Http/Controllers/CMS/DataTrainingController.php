<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\DataTrainingRequest;
use App\Repositories\DataTrainingRepositories;
use Illuminate\Http\Request;

class DataTrainingController extends Controller
{
    protected $dataTraining;

    public function __construct(DataTrainingRepositories $dataTraining)
    {
        $this->dataTraining = $dataTraining;
    }
    public function getAllData()
    {
        return $this->dataTraining->getAllData();
    }
    public function getDataById($id)
    {
        return $this->dataTraining->getDataById($id);
    }
    public function createData(DataTrainingRequest $request)
    {
        return $this->dataTraining->createData($request);
    }
    public function updateData(DataTrainingRequest $request, $id)
    {
        return $this->dataTraining->updateData($request, $id);
    }
    public function deleteData($id)
    {
        return $this->dataTraining->deleteData($id);
    }
}
