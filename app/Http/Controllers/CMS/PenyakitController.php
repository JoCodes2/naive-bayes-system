<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\PenyakitRequest;
use App\Repositories\PenyakitRepositories;
use Illuminate\Http\Request;

class PenyakitController extends Controller
{
    protected $PenyakitRepo;
    public function __construct(PenyakitRepositories $PenyakitRepo)
    {
        $this->PenyakitRepo = $PenyakitRepo;
    }
    public function getAllData()
    {
        return $this->PenyakitRepo->getAllData();
    }
    public function createData(PenyakitRequest $request)
    {
        return $this->PenyakitRepo->createData($request);
    }
    public function getDataById($id)
    {
        return $this->PenyakitRepo->getDataById($id);
    }

    public function updateData(PenyakitRequest $request, $id)
    {
        return $this->PenyakitRepo->updateData($request, $id);
    }
    public function deleteData($id)
    {
        return $this->PenyakitRepo->deleteData($id);
    }
}
