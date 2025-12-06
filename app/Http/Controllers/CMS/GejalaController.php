<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\GejalaRequest;
use App\Repositories\GejalaRepositories;
use Illuminate\Http\Request;

class GejalaController extends Controller
{
    protected $gejalaRepo;

    public function __construct(GejalaRepositories $gejalaRepo)
    {
        $this->gejalaRepo = $gejalaRepo;
    }
    public function getAllData()
    {
        return $this->gejalaRepo->getAllData();
    }
    public function createData(GejalaRequest $request)
    {
        return $this->gejalaRepo->createData($request);
    }
    public function getDataById($id)
    {
        return $this->gejalaRepo->getDataById($id);
    }
    public function updateData(GejalaRequest $request, $id)
    {
        return $this->gejalaRepo->updateData($request, $id);
    }
    public function deleteData($id)
    {
        return $this->gejalaRepo->deleteData($id);
    }
}
