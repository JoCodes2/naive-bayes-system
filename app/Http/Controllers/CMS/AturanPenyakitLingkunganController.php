<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\AturanPenyakitLingkunganRequest;
use App\Repositories\AturanPenyakitLingkunganRepositories;
use Illuminate\Http\Request;

class AturanPenyakitLingkunganController extends Controller
{
    protected $AturanPenyakitLingkunganRepo;
    public function __construct(AturanPenyakitLingkunganRepositories $AturanPenyakitLingkunganRepo)
    {
        $this->AturanPenyakitLingkunganRepo = $AturanPenyakitLingkunganRepo;
    }
    public function getAllData()
    {
        return $this->AturanPenyakitLingkunganRepo->getAllData();
    }
    public function createData(AturanPenyakitLingkunganRequest $request)
    {
        return $this->AturanPenyakitLingkunganRepo->createData($request);
    }
    public function getDataById($id)
    {
        return $this->AturanPenyakitLingkunganRepo->getDataById($id);
    }

    public function updateData(AturanPenyakitLingkunganRequest $request, $id)
    {
        return $this->AturanPenyakitLingkunganRepo->updateData($request, $id);
    }
    public function deleteData($id)
    {
        return $this->AturanPenyakitLingkunganRepo->deleteData($id);
    }
}
