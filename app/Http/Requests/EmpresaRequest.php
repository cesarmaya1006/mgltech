<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmpresaRequest extends FormRequest
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
            'identificacion' => 'required|unique:empresas,identificacion,' . $this->route('id'),

        ];
    }
    public function attributes()
    {
        return [
            'identificacion' => 'Identificación',

        ];
    }

    public function messages()
    {
        return [
            'identificacion.required' => 'El campo identificación es obligatorio',
            'identificacion.unique' => 'El campo identificación ya se encuentra en la base de datos verifique la información e intentelo nuevamente',

        ];
    }
}
