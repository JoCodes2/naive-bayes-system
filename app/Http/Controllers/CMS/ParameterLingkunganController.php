<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\ParameterRequest;
use App\Repositories\ParameterRepositories;
use Illuminate\Http\Request;

class ParameterLingkunganController extends Controller
{
    protected $parameterRepo;
    public function __construct(ParameterRepositories $parameterRepo)
    {
        $this->parameterRepo = $parameterRepo;
    }
    public function getAllData()
    {
        return $this->parameterRepo->getAllData();
    }
    public function createData(ParameterRequest $request)
    {
        return $this->parameterRepo->createData($request);
    }
    public function getDataById($id)
    {
        return $this->parameterRepo->getDataById($id);
    }
    public function updateData(ParameterRequest $request, $id)
    {
        return $this->parameterRepo->updateData($request, $id);
    }
    public function deleteData($id)
    {
        return $this->parameterRepo->deleteData($id);
    }
}
