<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\AturanGejalaRequest;
use App\Repositories\AturanGejalaRepositories;
use Illuminate\Http\Request;

class AturanGejalaController extends Controller
{
    protected $AturanGejalaRepo;
    public function __construct(AturanGejalaRepositories $AturanGejalaRepo)
    {
        $this->AturanGejalaRepo = $AturanGejalaRepo;
    }
    public function getAllData()
    {
        return $this->AturanGejalaRepo->getAllData();
    }

    public function createData(AturanGejalaRequest $request)
    {
        return $this->AturanGejalaRepo->createData($request);
    }
    public function getDataById($id)
    {
        return $this->AturanGejalaRepo->getDataById($id);
    }

    public function updateData(AturanGejalaRequest $request, $id)
    {
        return $this->AturanGejalaRepo->updateData($request, $id);
    }
    public function deleteData($id)
    {
        return $this->AturanGejalaRepo->deleteData($id);
    }

    // public function getKode()
    // {
    //     return $this->AturanGejalaRepo->getKode();
    // }
}
