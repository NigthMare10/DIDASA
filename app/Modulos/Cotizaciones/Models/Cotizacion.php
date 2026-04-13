<?php

namespace App\Modulos\Cotizaciones\Models;

use App\Models\User;
use App\Modulos\Vehiculos\Models\Vehiculo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cotizacion extends Model
{
    protected $table = 'cotizaciones';

    protected $fillable = [
        'user_id',
        'vehiculo_id',
        'numero_cotizacion',
        'estado',
        'subtotal',
        'impuesto',
        'total',
        'notas',
        'enviada_en',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'impuesto' => 'decimal:2',
            'total' => 'decimal:2',
            'enviada_en' => 'datetime',
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

    public function items(): HasMany
    {
        return $this->hasMany(CotizacionItem::class);
    }
}
