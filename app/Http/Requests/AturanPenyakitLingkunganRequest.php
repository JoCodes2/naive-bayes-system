<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AturanPenyakitLingkunganRequest extends FormRequest
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
        $id = $this->route('id'); // untuk pengecualian unique saat update

        return [
            'penyakit_id'       => 'required|exists:penyakit,id',
            'parameter_id'      => 'required|exists:parameter_lingkungan,id',
            'kondisi'           => 'required|string|max:255',
            'bobot_pengaruh'    => 'required|numeric|between:0.1,1',
        ];
    }

    public function messages(): array
    {
        return [
            'penyakit_id.required'      => 'Penyakit wajib dipilih.',
            'penyakit_id.exists'        => 'Penyakit tidak valid.',

            'parameter_id.required'     => 'Parameter lingkungan wajib dipilih.',
            'parameter_id.exists'       => 'Parameter lingkungan tidak valid.',

            'kondisi.required'          => 'Kondisi wajib diisi.',
            'kondisi.string'            => 'Kondisi harus berupa teks.',

            'bobot_pengaruh.required'   => 'Bobot wajib diisi.',
            'bobot_pengaruh.numeric'    => 'Bobot harus berupa angka.',
            'bobot_pengaruh.between'    => 'Bobot harus bernilai antara 0.1 hingga 1.',
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
