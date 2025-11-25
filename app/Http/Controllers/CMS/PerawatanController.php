<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\PerawatanRequest;
use App\Repositories\PerawatanRepositories;
use Illuminate\Http\Request;

class PerawatanController extends Controller
{
    protected $PerawatanRepo;
    public function __construct(PerawatanRepositories $PerawatanRepo)
    {
        $this->PerawatanRepo = $PerawatanRepo;
    }
    public function getAllData()
    {
        return $this->PerawatanRepo->getAllData();
    }
    public function createData(PerawatanRequest $request)
    {
        return $this->PerawatanRepo->createData($request);
    }
    public function getDataById($id)
    {
        return $this->PerawatanRepo->getDataById($id);
    }

    public function updateData(PerawatanRequest $request, $id)
    {
        return $this->PerawatanRepo->updateData($request, $id);
    }
    public function deleteData($id)
    {
        return $this->PerawatanRepo->deleteData($id);
    }
}
