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
            'fecha' => ['required', 'date'],
            'hora' => ['required', 'date_format:H:i'],
            'notas' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            /** @var DisponibilidadCitasService $servicio */
            $servicio = app(DisponibilidadCitasService::class);

            if (! $servicio->fechaEsValida((string) $this->input('fecha'))) {
                $validator->errors()->add('fecha', 'La fecha seleccionada no esta disponible.');
            }

            if (! $servicio->obtenerHorasDisponibles((string) $this->input('fecha'))->contains($this->input('hora'))) {
                $validator->errors()->add('hora', 'La hora seleccionada ya no esta disponible.');
            }
        });
    }
}
