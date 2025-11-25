<?php

namespace App\Repositories;

use App\Http\Requests\RekomendasiPencegahanRequest;
use App\Interfaces\RekomendasiPencegahanInterfaces;

class RekomendasiPencegahanRepositories implements RekomendasiPencegahanInterfaces
{
    public function getAllData() {}
    public function getDataById($id) {}
    public function createData(RekomendasiPencegahanRequest $request) {}
    public function updateData(RekomendasiPencegahanRequest $request, $id) {}
    public function deleteData($id) {}
}
