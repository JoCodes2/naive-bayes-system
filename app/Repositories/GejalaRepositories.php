<?php

namespace App\Repositories;

use App\Http\Requests\GejalaRequest;
use App\Interfaces\GejalaInterfaces;
use App\Models\GejalaModel;
use App\Traits\HttpResponseTraits;

class GejalaRepositories implements GejalaInterfaces
{
    use HttpResponseTraits;
    protected $gejalaModel;
    public function __construct(GejalaModel $gejalaModel)
    {
        $this->gejalaModel = $gejalaModel;
    }
    public function getAllData()
    {
        $data = $this->gejalaModel->all();
        if (!$data) {
            return $this->dataNotFound();
        }
        return $this->success($data);
    }
    public function getDataById($id)
    {
        $data = $this->gejalaModel->find($id);
        if (!$data) {
            return $this->idOrDataNotFound();
        }
        return $this->success($data);
    }
    public function createData(GejalaRequest $request)
    {
        try {
            $data = new $this->gejalaModel;
            $data->kode_gejala = $request->input('kode_gejala');
            $data->nama_gejala = $request->input('nama_gejala');
            $data->kategori = $request->input('kategori');
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
            $data->kode_gejala = $request->input('kode_gejala');
            $data->nama_gejala = $request->input('nama_gejala');
            $data->kategori = $request->input('kategori');
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
            return $this->success($data);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }
}
