<?php

namespace App\Modulos\OrdenesTrabajo\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrdenTrabajoEvento extends Model
{
    protected $table = 'orden_trabajo_eventos';

    protected $fillable = [
        'orden_trabajo_id',
        'titulo',
        'descripcion',
        'estado_etapa',
        'orden',
        'completado',
    ];

    protected function casts(): array
    {
        return [
            'orden' => 'integer',
            'completado' => 'boolean',
        ];
    }

    public function ordenTrabajo(): BelongsTo
    {
        return $this->belongsTo(OrdenTrabajo::class);
    }
}
