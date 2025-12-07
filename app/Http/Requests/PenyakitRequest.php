<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class PenyakitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function rules(): array
    {
        $id = $this->route('id'); // ambil ID dari route /update/{id}

        return [
            'kode_penyakit' => 'required|unique:penyakit,kode_penyakit,' . $id,
            'nama_penyakit' => 'required',
            'deskripsi' => 'required',
            'solusi_perawatan' => 'required',
            'tindakan_pencegahan' => 'required',
            'faktor_risiko' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'kode_penyakit.required' => 'Kode penyakit wajib diisi.',
            'kode_penyakit.unique' => 'Kode penyakit sudah digunakan, silakan gunakan kode lain.',

            'nama_penyakit.required' => 'Nama penyakit wajib diisi.',
            'deskripsi.required' => 'Deskripsi penyakit wajib diisi.',
            'solusi_perawatan.required' => 'Solusi perawatan wajib diisi.',
            'tindakan_pencegahan.required' => 'Tindakan pencegahan wajib diisi.',
            'faktor_risiko.required' => 'Faktor risiko wajib diisi.',
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
