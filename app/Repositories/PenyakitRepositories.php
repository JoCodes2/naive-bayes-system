<?php

namespace App\Repositories;

use App\Http\Requests\PenyakitRequest;
use App\Interfaces\PenyakitInterfaces;
use App\Models\PenyakitModel;
use App\Traits\HttpResponseTraits;

class PenyakitRepositories implements PenyakitInterfaces
{
    protected $PenyakitModel;
    use HttpResponseTraits;

    public function __construct(PenyakitModel $PenyakitModel)
    {
        $this->PenyakitModel = $PenyakitModel;
    }

    public function getAllData()
    {
        $data = $this->PenyakitModel::all();
        if (!$data) {
            return $this->dataNotFound();
        } else {
            return $this->success($data);
        }
    }
    public function getDataById($id)
    {
        $data = $this->PenyakitModel::where('id', $id)->first();
        if (!$data) {
            return $this->dataNotFound();
        } else {
            return $this->success($data);
        }
    }
    public function createData(PenyakitRequest $request)
    {
        try {
            $data = new $this->PenyakitModel;
            $data->nama = $request->input('nama');
            $data->deskripsi = $request->input('deskripsi');
            $data->save();

            return $this->success($data);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }
    public function updateData(PenyakitRequest $request, $id)
    {
        try {
            $data = $this->PenyakitModel::where('id', $id)->first();
            $data->nama = $request->input('nama');
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
            $data = $this->PenyakitModel::where('id', $id)->first();

            $data->delete();

            return $this->delete();
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }
}
