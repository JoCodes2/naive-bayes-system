<?php

namespace App\Repositories;

use App\Http\Requests\AturanPenyakitLingkunganRequest;
use App\Interfaces\AturanPenyakitLingkunganInterfaces;
use App\Models\AturanPenyakitLingkunganModel;
use App\Traits\HttpResponseTraits;

class AturanPenyakitLingkunganRepositories implements AturanPenyakitLingkunganInterfaces
{
    protected $AturanPenyakitLingkunganModel;
    use HttpResponseTraits;

    public function __construct(AturanPenyakitLingkunganModel $AturanPenyakitLingkunganModel)
    {
        $this->AturanPenyakitLingkunganModel = $AturanPenyakitLingkunganModel;
    }

    public function getAllData()
    {
        try {
            $data = $this->AturanPenyakitLingkunganModel
                ->with([
                    'penyakit:id,nama_penyakit',
                    'parameter:id,nama_parameter'
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
        $data = $this->AturanPenyakitLingkunganModel::find($id);

        if (!$data) {
            return $this->dataNotFound();
        }

        return $this->success($data);
    }

    public function createData(AturanPenyakitLingkunganRequest $request)
    {
        try {
            $data = new $this->AturanPenyakitLingkunganModel;

            $data->penyakit_id       = $request->penyakit_id;
            $data->parameter_id       = $request->parameter_id;
            $data->kondisi           = $request->kondisi;
            $data->bobot_pengaruh    = $request->bobot_pengaruh;

            $data->save();

            return $this->success($data);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }

    public function updateData(AturanPenyakitLingkunganRequest $request, $id)
    {
        try {
            $data = $this->AturanPenyakitLingkunganModel::find($id);

            if (!$data) {
                return $this->dataNotFound();
            }

            $data->penyakit_id       = $request->penyakit_id;
            $data->parameter_id       = $request->parameter_id;
            $data->kondisi           = $request->kondisi;
            $data->bobot_pengaruh    = $request->bobot_pengaruh;

            $data->save();

            return $this->success($data);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }

    public function deleteData($id)
    {
        try {
            $data = $this->AturanPenyakitLingkunganModel::find($id);

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
