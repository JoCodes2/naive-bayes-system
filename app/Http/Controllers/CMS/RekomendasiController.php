<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\RekomendasiPencegahanRequest;
use App\Repositories\RekomendasiPencegahanRepositories;
use Illuminate\Http\Request;

class RekomendasiController extends Controller
{
    protected $rekomendasiRepo;

    public function __construct(RekomendasiPencegahanRepositories $rekomendasiRepo)
    {
        $this->rekomendasiRepo = $rekomendasiRepo;
    }

    public function getAllData()
    {
        return $this->rekomendasiRepo->getAllData();
    }

    public function getDataById($id)
    {
        return $this->rekomendasiRepo->getDataById($id);
    }

    public function createData(RekomendasiPencegahanRequest $request)
    {
        return $this->rekomendasiRepo->createData($request);
    }
    public function updateData(RekomendasiPencegahanRequest $request, $id)
    {
        return $this->rekomendasiRepo->updateData($request, $id);
    }
    public function deleteData($id)
    {
        return $this->rekomendasiRepo->deleteData($id);
    }
}
