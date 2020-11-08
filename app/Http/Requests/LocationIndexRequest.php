<?php

namespace App\Http\Requests;

use Urameshibr\Requests\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LocationIndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'filter.ip' => 'max:50',
            'filter.latitude' => 'max:50',
            'filter.longitude' => 'max:50',
            'filter.cidade' => 'max:50',
            'filter.estado' => 'max:2'
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */

    public function messages()
    {
        return [
            'filter.ip.max' => 'O ip não pode ter mais que :max caracteres.',
            'filter.latitude.max' => 'A sigla não pode ter mais que :max caracteres.',
            'filter.longitude.max' => 'O e-mail não pode ter mais que :max caracteres.',
            'filter.cidade.max' => 'A url não pode ter mais que :max caracteres.',
            'filter.estado.max' => 'O status não pode ter mais que :max caracteres.'
        ];
    }

    /**
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(
            [
                "success" => false,
                "code" => 422,
                "error" => $validator->errors(),
                "message" => "Um ou mais campos são requiridos."
            ], 422));
    }

}
