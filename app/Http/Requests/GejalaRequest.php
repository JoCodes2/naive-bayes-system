<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Exceptions\HttpResponseException;

class GejalaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isUpdate = $this->route()->getName() === 'gejala.update'
            || $this->route()->uri() === 'naive-bayes/gejala/update/{id}';

        return [
            'kode_gejala' => [
                'required',
                $isUpdate
                    ? Rule::unique('gejala', 'kode_gejala')->ignore($this->id)
                    : Rule::unique('gejala', 'kode_gejala')
            ],
            'deskripsi_gejala' => 'required',
            'kategori' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'kode_gejala.required' => 'Kode gejala tidak boleh kosong.',
            'kode_gejala.unique'   => 'Kode gejala sudah digunakan, pilih kode lain.',
            'deskripsi_gejala.required' => 'Deskripsi gejala tidak boleh kosong.',
            'kategori.required' => 'Kategori harus dipilih.',
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'code'    => 422,
                'status'  => 'validation_failed',
                'message' => 'Check your input data',
                'data'    => $validator->errors(),
            ], 422)
        );
    }
}
