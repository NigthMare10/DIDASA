<?php

namespace App\Modulos\Vehiculos\Models;

use App\Models\User;
use App\Modulos\Citas\Models\Cita;
use App\Modulos\Cotizaciones\Models\Cotizacion;
use App\Modulos\OrdenesTrabajo\Models\OrdenTrabajo;
use Database\Factories\VehiculoFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehiculo extends Model
{
    /** @use HasFactory<VehiculoFactory> */
    use HasFactory;

    protected $table = 'vehiculos';

    protected $fillable = [
        'user_id',
        'marca',
        'modelo',
        'anio',
        'placa',
        'vin',
        'kilometraje',
        'color',
    ];

    protected function casts(): array
    {
        return [
            'anio' => 'integer',
            'kilometraje' => 'integer',
        ];
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function cotizaciones(): HasMany
    {
        return $this->hasMany(Cotizacion::class);
    }

    public function citas(): HasMany
    {
        return $this->hasMany(Cita::class);
    }

    public function ordenesTrabajo(): HasMany
    {
        return $this->hasMany(OrdenTrabajo::class);
    }

    protected static function newFactory(): VehiculoFactory
    {
        return VehiculoFactory::new();
    }
}
