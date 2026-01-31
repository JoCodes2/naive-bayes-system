<?php

namespace App\Repositories;

use App\Http\Requests\ParameterRequest;
use App\Interfaces\ParameterInterfaces;
use App\Models\KondisiLingkunganModel;
use App\Models\ParameterLingkunganModel;
use App\Traits\HttpResponseTraits;

class ParameterRepositories implements ParameterInterfaces
{
    use HttpResponseTraits;
    protected $parameterModel;
    public function __construct(KondisiLingkunganModel $parameterModel)
    {
        $this->parameterModel = $parameterModel;
    }
    public function getAllData()
    {
        $data = $this->parameterModel::all();
        if (!$data) {
            return $this->dataNotFound();
        }
        return $this->success($data);
    }
    public function getDataById($id)
    {
        $data = $this->parameterModel::find($id);
        if (!$data) {
            return $this->idOrDataNotFound();
        }
        return $this->success($data);
    }
    public function createData(ParameterRequest $request)
    {
        try {
            $data = new $this->parameterModel;
            $data->nama_parameter = $request->input('nama_parameter');
            $data->satuan = $request->input('satuan');
            $data->nilai_label = $request->input('nilai_label');
            $data->min_value = $request->input('min_value');
            $data->max_value = $request->input('max_value');
            $data->deskripsi = $request->input('deskripsi');
            $data->save();
            return $this->success($data);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }
    public function updateData(ParameterRequest $request, $id)
    {
        try {
            $data = $this->parameterModel::find($id);
            if (!$data) {
                return $this->idOrDataNotFound();
            }
            $data->nama_parameter = $request->input('nama_parameter');
            $data->satuan = $request->input('satuan');
            $data->nilai_label = $request->input('nilai_label');
            $data->min_value = $request->input('min_value');
            $data->max_value = $request->input('max_value');
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
            $data = $this->parameterModel::where('id', $id)->first();
            $data->delete();
            return $this->success($data);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }
}
