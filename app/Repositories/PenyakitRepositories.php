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

        if ($data->isEmpty()) {
            return $this->dataNotFound();
        }

        return $this->success($data);
    }

    public function getDataById($id)
    {
        $data = $this->PenyakitModel::find($id);

        if (!$data) {
            return $this->dataNotFound();
        }

        return $this->success($data);
    }

    public function createData(PenyakitRequest $request)
    {
        try {
            $data = new $this->PenyakitModel;

            $data->kode_penyakit       = $request->kode_penyakit;
            $data->nama_penyakit       = $request->nama_penyakit;
            $data->deskripsi           = $request->deskripsi;
            $data->solusi_perawatan    = $request->solusi_perawatan;
            $data->tindakan_pencegahan = $request->tindakan_pencegahan;
            $data->faktor_risiko       = $request->faktor_risiko;

            $data->save();

            return $this->success($data);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }

    public function updateData(PenyakitRequest $request, $id)
    {
        try {
            $data = $this->PenyakitModel::find($id);

            if (!$data) {
                return $this->dataNotFound();
            }

            $data->kode_penyakit       = $request->kode_penyakit;
            $data->nama_penyakit       = $request->nama_penyakit;
            $data->deskripsi           = $request->deskripsi;
            $data->solusi_perawatan    = $request->solusi_perawatan;
            $data->tindakan_pencegahan = $request->tindakan_pencegahan;
            $data->faktor_risiko       = $request->faktor_risiko;

            $data->save();

            return $this->success($data);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }

    public function deleteData($id)
    {
        try {
            $data = $this->PenyakitModel::find($id);

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
