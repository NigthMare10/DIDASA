<?php

namespace App\Modulos\OrdenesTrabajo\Models;

use App\Models\User;
use App\Modulos\Citas\Models\Cita;
use App\Modulos\Vehiculos\Models\Vehiculo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrdenTrabajo extends Model
{
    protected $table = 'ordenes_trabajo';

    protected $fillable = [
        'user_id',
        'vehiculo_id',
        'cita_id',
        'numero_orden',
        'titulo',
        'descripcion',
        'estado',
        'progreso',
        'fecha_ingreso',
        'fecha_estimada',
        'fecha_entrega',
        'total_estimado',
    ];

    protected function casts(): array
    {
        return [
            'fecha_ingreso' => 'date',
            'fecha_estimada' => 'date',
            'fecha_entrega' => 'date',
            'progreso' => 'integer',
            'total_estimado' => 'decimal:2',
        ];
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function vehiculo(): BelongsTo
    {
        return $this->belongsTo(Vehiculo::class);
    }

    public function cita(): BelongsTo
    {
        return $this->belongsTo(Cita::class);
    }

    public function eventos(): HasMany
    {
        return $this->hasMany(OrdenTrabajoEvento::class)->orderBy('orden');
    }
}
