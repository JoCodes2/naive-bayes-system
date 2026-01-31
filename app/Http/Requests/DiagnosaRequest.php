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
            'nama_petani' => 'required',
            'gejala' => 'required|array|min:1',
            'gejala.*' => 'string|exists:gejala,kode_gejala',

            'lingkungan' => 'required|array|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_petani.required' => 'Nama harus diisi.',
            'gejala.required' => 'Pilih minimal satu gejala yang terlihat pada tanaman.',
            'gejala.*.exists' => 'Kode gejala tidak valid atau tidak terdaftar.',
            'lingkungan.required' => 'Pilih kondisi lingkungan/sensor saat ini.',
            'lingkungan.array' => 'Format data lingkungan harus berupa objek parameter.',
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
