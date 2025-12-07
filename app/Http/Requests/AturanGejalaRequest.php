<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AturanGejalaRequest extends FormRequest
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
        return [
            'penyakit_id' => 'required|exists:penyakit,id',
            'gejala_id'   => 'required|exists:gejala,id',
            'bobot'       => 'required|numeric|between:0.1,1', // <= Range 0.1 - 1
        ];
    }

    public function messages(): array
    {
        return [
            'penyakit_id.required' => 'Penyakit wajib dipilih.',
            'penyakit_id.exists'   => 'Penyakit yang dipilih tidak valid.',

            'gejala_id.required'   => 'Gejala wajib dipilih.',
            'gejala_id.exists'     => 'Gejala yang dipilih tidak valid.',

            'bobot.required'       => 'Bobot wajib diisi.',
            'bobot.numeric'        => 'Bobot harus berupa angka.',
            'bobot.between'        => 'Bobot harus berada antara 0.1 sampai 1.',
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
