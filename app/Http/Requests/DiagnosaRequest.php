<?php
// app/Http/Requests/DiagnosaRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class DiagnosaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kondisi_lingkungan' => 'required|array',
            'kondisi_lingkungan.suhu_udara' => 'required|numeric|min:0|max:50',
            'kondisi_lingkungan.kelembapan_udara' => 'required|numeric|min:0|max:100',
            'kondisi_lingkungan.ph_tanah' => 'required|numeric|min:0|max:14',
            'kondisi_lingkungan.intensitas_cahaya' => 'required|numeric|min:0',
            'kondisi_lingkungan.curah_hujan' => 'required|numeric|min:0',
            'kondisi_lingkungan.kelembapan_tanah' => 'required|numeric|min:0|max:100',
            'gejala' => 'required|array|min:1',
            'gejala.*' => 'exists:gejala,id'
        ];
    }

    public function messages(): array
    {
        return [
            'kondisi_lingkungan.required' => 'Data kondisi lingkungan harus diisi',
            'gejala.required' => 'Pilih minimal 1 gejala tanaman',
            'gejala.min' => 'Pilih minimal 1 gejala tanaman'
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => "not validate",
            'message' => 'Check your validation',
            'data' => $validator->errors(),
        ], 422));
    }
}
