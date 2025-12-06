<?php

namespace App\Repositories;

use App\Http\Requests\AturanGejalaRequest;
use App\Interfaces\AturanGejalaInterfaces;
use App\Models\AturanGejalaModel;
use App\Traits\HttpResponseTraits;

class AturanGejalaRepositories implements AturanGejalaInterfaces
{
    protected $AturanGejalaModel;
    use HttpResponseTraits;

    public function __construct(AturanGejalaModel $AturanGejalaModel)
    {
        $this->AturanGejalaModel = $AturanGejalaModel;
    }

    public function getAllData()
    {
        try {
            $data = $this->AturanGejalaModel
                ->with([
                    'penyakit:id,kode_penyakit,nama_penyakit',
                    'gejala:id,kode_gejala'
                ])
                ->get();

            if ($data->isEmpty()) {
                return $this->dataNotFound();
            }

            return $this->success($data);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }

    public function getDataById($id)
    {
        $data = $this->AturanGejalaModel::find($id);

        if (!$data) {
            return $this->dataNotFound();
        }

        return $this->success($data);
    }

    public function createData(AturanGejalaRequest $request)
    {
        try {
            $data = new $this->AturanGejalaModel;

            $data->penyakit_id       = $request->penyakit_id;
            $data->gejala_id       = $request->gejala_id;
            $data->bobot           = $request->bobot;

            $data->save();

            return $this->success($data);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }

    public function updateData(AturanGejalaRequest $request, $id)
    {
        try {
            $data = $this->AturanGejalaModel::find($id);

            if (!$data) {
                return $this->dataNotFound();
            }

            $data->penyakit_id       = $request->penyakit_id;
            $data->gejala_id       = $request->gejala_id;
            $data->bobot           = $request->bobot;

            $data->save();

            return $this->success($data);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }

    public function deleteData($id)
    {
        try {
            $data = $this->AturanGejalaModel::find($id);

            if (!$data) {
                return $this->dataNotFound();
            }

            $data->delete();

            return $this->delete(); // dari HttpResponseTraits
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }
}
