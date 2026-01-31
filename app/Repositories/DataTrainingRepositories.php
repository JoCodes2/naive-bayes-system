<?php

namespace App\Repositories;

use App\Http\Requests\DataTrainingRequest;
use App\Interfaces\DataTrainingInterfaces;
use App\Models\DataTrainingModel;
use App\Traits\HttpResponseTraits;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DataTrainingRepositories implements DataTrainingInterfaces
{
    use HttpResponseTraits;
    protected $dataModel;

    public function __construct(DataTrainingModel $dataModel)
    {
        $this->dataModel = $dataModel;
    }

    public function getAllData()
    {
        $data = $this->dataModel::with('penyakit')->latest()->get();

        if ($data->isEmpty()) {
            return $this->dataNotFound();
        }

        return $this->success($data);
    }

    public function createData(DataTrainingRequest $request)
    {
        try {
            $data = $this->dataModel::create([
                'penyakit_id' => $request->penyakit_id,
                'gejala' => $request->gejala,
                'lingkungan' => $request->lingkungan,
            ]);

            return $this->success($data, 'Dataset training berhasil ditambahkan');
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }

    public function getDataById($id)
    {
        $data = $this->dataModel::with('penyakit')->find($id);
        if (!$data) {
            return $this->idOrDataNotFound();
        }
        return $this->success($data);
    }

    public function updateData(DataTrainingRequest $request, $id)
    {
        try {
            $data = $this->dataModel::find($id);
            if (!$data) return $this->idOrDataNotFound();

            $data->update([
                'penyakit_id' => $request->penyakit_id,
                'gejala' => $request->gejala,
                'lingkungan' => $request->lingkungan,
            ]);

            return $this->success($data, 'Dataset training berhasil diperbarui');
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }

    public function deleteData($id)
    {
        try {
            $data = $this->dataModel::find($id);
            if (!$data) return $this->dataNotFound();

            $data->delete();
            return $this->success(null, 'Dataset training berhasil dihapus');
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }
}
