<?php

namespace App\Modulos\Cotizaciones\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class CrearCotizacionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    protected function prepareForValidation(): void
    {
        $items = json_decode((string) $this->input('itemsJson', '[]'), true);

        $this->merge([
            'vehiculoId' => $this->input('vehiculoId'),
            'items' => is_array($items) ? $items : [],
        ]);
    }

    public function rules(): array
    {
        return [
            'vehiculoId' => ['required', 'integer', 'exists:vehiculos,id'],
            'notas' => ['nullable', 'string', 'max:1000'],
            'itemsJson' => ['required', 'string'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.tipoItem' => ['required', 'string', 'in:servicio,paquete,manual'],
            'items.*.servicioId' => ['nullable', 'integer', 'exists:servicios,id'],
            'items.*.paqueteId' => ['nullable', 'integer', 'exists:paquetes,id'],
            'items.*.descripcion' => ['nullable', 'string', 'max:150'],
            'items.*.cantidad' => ['required', 'integer', 'min:1', 'max:20'],
            'items.*.precioUnitario' => ['nullable', 'numeric', 'min:0', 'max:999999.99'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            foreach ($this->input('items', []) as $indice => $item) {
                $tipo = $item['tipoItem'] ?? null;

                if ($tipo === 'servicio' && empty($item['servicioId'])) {
                    $validator->errors()->add("items.$indice.servicioId", 'Debes seleccionar un servicio valido.');
                }

                if ($tipo === 'paquete' && empty($item['paqueteId'])) {
                    $validator->errors()->add("items.$indice.paqueteId", 'Debes seleccionar un paquete valido.');
                }

                if ($tipo === 'manual' && (empty($item['descripcion']) || ! isset($item['precioUnitario']))) {
                    $validator->errors()->add("items.$indice.descripcion", 'Los items manuales requieren descripcion y precio.');
                }
            }
        });
    }
}
