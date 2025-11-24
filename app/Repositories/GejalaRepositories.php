<?php

namespace App\Repositories;

use App\Http\Requests\GejalaRequest;
use App\Interfaces\GejalaInterfaces;
use App\Models\GejalaModel;
use App\Traits\HttpResponseTraits;

class GejalaRepositories implements GejalaInterfaces
{
    protected $gejalaModel;
    use HttpResponseTraits;

    public function __construct(GejalaModel $gejalaModel)
    {
        $this->gejalaModel = $gejalaModel;
    }

    public function getAllData()
    {
        $data = $this->gejalaModel::all();
        if (!$data) {
            return $this->dataNotFound();
        } else {
            return $this->success($data);
        }
    }
    public function getDataById($id)
    {
        $data = $this->gejalaModel::where('id', $id)->first();
        if (!$data) {
            return $this->dataNotFound();
        } else {
            return $this->success($data);
        }
    }
    public function createData(GejalaRequest $request)
    {
        try {
            $data = new $this->gejalaModel;
            $data->nama = $request->input('nama');
            $data->deskripsi = $request->input('deskripsi');
            $data->save();

            return $this->success($data);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }
    public function updateData(GejalaRequest $request, $id)
    {
        try {
            $data = $this->gejalaModel::where('id', $id)->first();
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
            $data = $this->gejalaModel::where('id', $id)->first();

            $data->delete();

            return $this->delete();
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }
}
