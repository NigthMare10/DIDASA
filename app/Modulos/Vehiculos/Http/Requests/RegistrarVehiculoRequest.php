<?php

namespace App\Modulos\Vehiculos\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegistrarVehiculoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'marca' => ['required', 'string', 'max:60'],
            'modelo' => ['required', 'string', 'max:60'],
            'anio' => ['required', 'integer', 'min:1980', 'max:'.(date('Y') + 1)],
            'placa' => ['required', 'string', 'max:20', Rule::unique('vehiculos', 'placa')],
            'vin' => ['nullable', 'string', 'max:40', Rule::unique('vehiculos', 'vin')],
            'kilometraje' => ['required', 'integer', 'min:0', 'max:9999999'],
            'color' => ['required', 'string', 'max:40'],
        ];
    }
}
