<?php

namespace App\Models;

use App\Modulos\Citas\Models\Cita;
use App\Modulos\Cotizaciones\Models\Cotizacion;
use App\Modulos\Fidelidad\Models\MovimientoPunto;
use App\Modulos\Fidelidad\Models\UsuarioInsignia;
use App\Modulos\OrdenesTrabajo\Models\OrdenTrabajo;
use App\Modulos\Vehiculos\Models\Vehiculo;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function vehiculos(): HasMany
    {
        return $this->hasMany(Vehiculo::class);
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

    public function movimientosPuntos(): HasMany
    {
        return $this->hasMany(MovimientoPunto::class);
    }

    public function insignias(): HasMany
    {
        return $this->hasMany(UsuarioInsignia::class);
    }

    public function obtenerIniciales(): string
    {
        return collect(explode(' ', trim($this->name)))
            ->filter()
            ->take(2)
            ->map(fn (string $segmento) => mb_strtoupper(mb_substr($segmento, 0, 1)))
            ->implode('');
    }
}
