<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class DataTrainingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'penyakit_id' => 'required|exists:penyakit,id',
            'gejala'      => 'required|array|min:1',
            'gejala.*'    => 'exists:gejala,id',
            'lingkungan'  => 'required|array|min:1',
            'lingkungan.*' => 'exists:kondisi_lingkungan,id',
        ];
    }

    public function messages(): array
    {
        return [
            'penyakit_id.required' => 'Penyakit wajib dipilih.',
            'penyakit_id.exists'   => 'Penyakit tidak valid.',
            'gejala.required'      => 'Pilih minimal satu gejala.',
            'gejala.array'         => 'Format data gejala tidak valid.',
            'gejala.*.exists'      => 'Salah satu gejala yang dipilih tidak terdaftar.',
            'lingkungan.required'  => 'Pilih minimal satu kondisi lingkungan.',
            'lingkungan.array'     => 'Format data lingkungan tidak valid.',
            'lingkungan.*.exists'  => 'Salah satu parameter lingkungan tidak terdaftar.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status'  => "not validate",
            'message' => 'Validasi gagal, silakan periksa kembali inputan Anda.',
            'data'    => $validator->errors(),
        ], 422));
    }
}
