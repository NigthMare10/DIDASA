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
            'marca' => ['required', 'string', 'min:2', 'max:60', "regex:/^[\pL\pN\s\-\.]+$/u"],
            'modelo' => ['required', 'string', 'min:2', 'max:60', "regex:/^[\pL\pN\s\-\.]+$/u"],
            'anio' => ['required', 'integer', 'min:1980', 'max:'.(date('Y') + 1)],
            'placa' => ['required', 'string', 'min:5', 'max:20', 'regex:/^[A-Z0-9\-]+$/', Rule::unique('vehiculos', 'placa')],
            'vin' => ['nullable', 'string', 'min:11', 'max:17', 'regex:/^[A-HJ-NPR-Z0-9]+$/', Rule::unique('vehiculos', 'vin')],
            'kilometraje' => ['required', 'integer', 'min:0', 'max:9999999'],
            'color' => ['required', 'string', 'min:3', 'max:40', "regex:/^[\pL\s\-]+$/u"],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'marca' => trim((string) $this->input('marca')),
            'modelo' => trim((string) $this->input('modelo')),
            'placa' => mb_strtoupper(trim((string) $this->input('placa'))),
            'vin' => $this->filled('vin') ? mb_strtoupper(trim((string) $this->input('vin'))) : null,
            'color' => trim((string) $this->input('color')),
        ]);
    }
}
