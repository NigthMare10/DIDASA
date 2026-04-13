<?php

namespace App\Modulos\Citas\Http\Requests;

use App\Modulos\Citas\Services\DisponibilidadCitasService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class CrearCitaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'vehiculoId' => ['required', 'integer', 'exists:vehiculos,id'],
            'fecha' => ['required', 'date_format:Y-m-d'],
            'hora' => ['required', 'date_format:H:i'],
            'notas' => ['nullable', 'string', 'max:800'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'notas' => $this->filled('notas') ? trim((string) $this->input('notas')) : null,
        ]);
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            /** @var DisponibilidadCitasService $servicio */
            $servicio = app(DisponibilidadCitasService::class);

            if ($this->user()?->vehiculos()->whereKey($this->integer('vehiculoId'))->doesntExist()) {
                $validator->errors()->add('vehiculoId', 'El vehiculo seleccionado no pertenece a tu cuenta.');
            }

            if (! $servicio->fechaEsValida((string) $this->input('fecha'))) {
                $validator->errors()->add('fecha', 'La fecha seleccionada no esta disponible.');
            }

            if (! $servicio->obtenerHorasDisponibles((string) $this->input('fecha'))->contains($this->input('hora'))) {
                $validator->errors()->add('hora', 'La hora seleccionada ya no esta disponible.');
            }
        });
    }
}
