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

            // Validasi Gejala: Harus array dan kodenya harus ada di tabel gejala
            'gejala'      => 'required|array|min:2',
            'gejala.*'    => 'required|string|exists:gejala,kode_gejala',

            // Validasi Lingkungan: Harus array asosiatif (key-value)
            'lingkungan'  => 'required|array|min:2',
            'lingkungan.*' => 'required|string|in:rendah,normal,tinggi', // Validasi berdasarkan label yang diizinkan
        ];
    }

    public function messages(): array
    {
        return [
            'gejala.*.exists' => 'Kode gejala :input tidak valid.',
            'lingkungan.*.in' => 'Kondisi lingkungan harus antara rendah, normal, atau tinggi.',
            'gejala.min'      => 'Pilih minimal 2 gejala.',
            'lingkungan.min'  => 'Pilih minimal 2 parameter lingkungan.',
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
