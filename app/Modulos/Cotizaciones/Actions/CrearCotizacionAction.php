<?php

namespace App\Modulos\Cotizaciones\Actions;

use App\Models\User;
use App\Modulos\Compartido\Enums\EstadoCotizacion;
use App\Modulos\Compartido\Enums\TipoCotizacionItem;
use App\Modulos\Cotizaciones\Events\CotizacionEnviada;
use App\Modulos\Cotizaciones\Models\Cotizacion;
use App\Modulos\Servicios\Models\Paquete;
use App\Modulos\Servicios\Models\Servicio;
use Illuminate\Support\Facades\DB;

class CrearCotizacionAction
{
    public function ejecutar(User $usuario, array $datos): Cotizacion
    {
        return DB::transaction(function () use ($usuario, $datos): Cotizacion {
            $itemsNormalizados = collect($datos['items'])->map(function (array $item): array {
                $cantidad = (int) ($item['cantidad'] ?? 1);

                return match ($item['tipoItem']) {
                    TipoCotizacionItem::Servicio->value => $this->normalizarServicio($item, $cantidad),
                    TipoCotizacionItem::Paquete->value => $this->normalizarPaquete($item, $cantidad),
                    default => $this->normalizarManual($item, $cantidad),
                };
            });

            $subtotal = $itemsNormalizados->sum('subtotal');
            $impuesto = round($subtotal * 0.15, 2);
            $total = $subtotal + $impuesto;

            $cotizacion = Cotizacion::create([
                'user_id' => $usuario->id,
                'vehiculo_id' => $datos['vehiculoId'],
                'numero_cotizacion' => 'COT-'.now()->format('YmdHis'),
                'estado' => EstadoCotizacion::Enviada->value,
                'subtotal' => $subtotal,
                'impuesto' => $impuesto,
                'total' => $total,
                'notas' => $datos['notas'] ?? null,
                'enviada_en' => now(),
            ]);

            $cotizacion->items()->createMany($itemsNormalizados->all());

            event(new CotizacionEnviada($cotizacion));

            return $cotizacion->load('items');
        });
    }

    private function normalizarServicio(array $item, int $cantidad): array
    {
        $servicio = Servicio::query()->whereKey($item['servicioId'])->firstOrFail();

        return [
            'tipo_item' => TipoCotizacionItem::Servicio->value,
            'servicio_id' => $servicio->id,
            'paquete_id' => null,
            'descripcion' => $servicio->nombre,
            'cantidad' => $cantidad,
            'precio_unitario' => $servicio->precio_base,
            'subtotal' => round($servicio->precio_base * $cantidad, 2),
        ];
    }

    private function normalizarPaquete(array $item, int $cantidad): array
    {
        $paquete = Paquete::query()->whereKey($item['paqueteId'])->firstOrFail();

        return [
            'tipo_item' => TipoCotizacionItem::Paquete->value,
            'servicio_id' => null,
            'paquete_id' => $paquete->id,
            'descripcion' => $paquete->nombre,
            'cantidad' => $cantidad,
            'precio_unitario' => $paquete->precio_base,
            'subtotal' => round($paquete->precio_base * $cantidad, 2),
        ];
    }

    private function normalizarManual(array $item, int $cantidad): array
    {
        $precioUnitario = round((float) $item['precioUnitario'], 2);

        return [
            'tipo_item' => TipoCotizacionItem::Manual->value,
            'servicio_id' => null,
            'paquete_id' => null,
            'descripcion' => (string) $item['descripcion'],
            'cantidad' => $cantidad,
            'precio_unitario' => $precioUnitario,
            'subtotal' => round($precioUnitario * $cantidad, 2),
        ];
    }
}
