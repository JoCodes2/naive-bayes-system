<?php

namespace App\Repositories;

use App\Http\Requests\PenyakitRequest;
use App\Http\Requests\PerawatanRequest;
use App\Interfaces\PenyakitInterfaces;
use App\Interfaces\PerawatanInterfaces;
use App\Models\PenyakitModel;
use App\Models\PerawatanModel;
use App\Traits\HttpResponseTraits;

class PerawatanRepositories implements PerawatanInterfaces
{
    protected $PerawatanModel;
    use HttpResponseTraits;

    public function __construct(PerawatanModel $PerawatanModel)
    {
        $this->PerawatanModel = $PerawatanModel;
    }

    public function getAllData()
    {
        $data = $this->PerawatanModel::all();
        if (!$data) {
            return $this->dataNotFound();
        } else {
            return $this->success($data);
        }
    }
    public function getDataById($id)
    {
        $data = $this->PerawatanModel::where('id', $id)->first();
        if (!$data) {
            return $this->dataNotFound();
        } else {
            return $this->success($data);
        }
    }
    public function createData(PerawatanRequest $request)
    {
        try {
            $data = new $this->PerawatanModel;
            $data->nama = $request->input('nama');
            $data->jenis = $request->input('jenis');
            $data->deskripsi = $request->input('deskripsi');
            $data->save();

            return $this->success($data);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }
    public function updateData(PerawatanRequest $request, $id)
    {
        try {
            $data = $this->PerawatanModel::where('id', $id)->first();
            $data->nama = $request->input('nama');
            $data->jenis = $request->input('jenis');
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
            $data = $this->PerawatanModel::where('id', $id)->first();

            $data->delete();

            return $this->delete();
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }
}
