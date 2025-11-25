<?php

namespace App\Repositories;

use App\Http\Requests\RekomendasiPencegahanRequest;
use App\Interfaces\RekomendasiPencegahanInterfaces;
use App\Models\RekomendasiPencegahanModel;
use App\Traits\HttpResponseTraits;

class RekomendasiPencegahanRepositories implements RekomendasiPencegahanInterfaces
{
    use HttpResponseTraits;
    protected $modelRekomendasi;
    public function __construct(RekomendasiPencegahanModel $modelRekomendasi)
    {
        $this->modelRekomendasi = $modelRekomendasi;
    }
    public function getAllData()
    {
        $data = $this->modelRekomendasi::all();
        if (!$data) {
            return $this->dataNotFound();
        } else {
            return $this->success($data);
        }
    }
    public function getDataById($id)
    {
        $data = $this->modelRekomendasi::where('id', $id)->first();
        if (!$data) {
            return $this->dataNotFound();
        } else {
            return $this->success($data);
        }
    }
    public function createData(RekomendasiPencegahanRequest $request)
    {
        try {
            $data = new $this->modelRekomendasi;
            $data->judul = $request->input('judul');
            $data->deskripsi = $request->input('deskripsi');
            $data->save();

            return $this->success($data);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }
    public function updateData(RekomendasiPencegahanRequest $request, $id)
    {
        try {
            $data = $this->modelRekomendasi::where('id', $id)->first();
            $data->judul = $request->input('judul');
            $data->deskripsi = $request->input('deskripsi');
            $data->save();

            return $this->success($data);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }
    public function deleteData($id)
    {
        try {
            $data = $this->modelRekomendasi::where('id', $id)->first();

            $data->delete();

            return $this->delete();
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }
}
