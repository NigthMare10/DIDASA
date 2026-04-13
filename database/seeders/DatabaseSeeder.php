<?php

namespace Database\Seeders;

use App\Models\User;
use App\Modulos\Fidelidad\Models\Insignia;
use App\Modulos\Fidelidad\Models\NivelFidelidad;
use App\Modulos\Servicios\Models\CategoriaServicio;
use App\Modulos\Servicios\Models\Paquete;
use App\Modulos\Servicios\Models\Servicio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $usuario = User::query()->updateOrCreate(
            ['email' => 'cesar@didasa.test'],
            [
                'name' => 'cesar martinez',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
        );

        $categorias = collect(config('didasa.categoriasInicio'))->map(function (array $categoria, int $indice) {
            return CategoriaServicio::query()->updateOrCreate(
                ['slug' => Str::slug($categoria['nombre'])],
                [
                    'nombre' => $categoria['nombre'],
                    'icono' => $categoria['icono'],
                    'descripcion' => $categoria['nombre'],
                    'orden' => $indice + 1,
                    'activo' => true,
                ],
            );
        });

        $servicioCambioAceite = Servicio::query()->updateOrCreate(
            ['slug' => 'cambio-de-aceite-premium'],
            [
                'categoria_servicio_id' => $categorias->firstWhere('slug', 'motor')?->id,
                'nombre' => 'Cambio de aceite premium',
                'descripcion' => 'Cambio de aceite, filtro y chequeo de niveles.',
                'precio_base' => 1450,
                'duracion_minutos' => 60,
                'visible_catalogo' => false,
                'activo' => true,
            ],
        );

        $servicioFrenos = Servicio::query()->updateOrCreate(
            ['slug' => 'inspeccion-de-frenos'],
            [
                'categoria_servicio_id' => $categorias->firstWhere('slug', 'frenos')?->id,
                'nombre' => 'Inspeccion de frenos',
                'descripcion' => 'Revision integral de frenos y desgaste.',
                'precio_base' => 850,
                'duracion_minutos' => 45,
                'visible_catalogo' => false,
                'activo' => true,
            ],
        );

        $paquete = Paquete::query()->updateOrCreate(
            ['slug' => 'mantenimiento-esencial'],
            [
                'nombre' => 'Mantenimiento esencial',
                'descripcion' => 'Paquete base para el cuidado preventivo del vehiculo.',
                'precio_base' => 2200,
                'visible_catalogo' => false,
                'activo' => true,
            ],
        );

        $paquete->servicios()->syncWithoutDetaching([$servicioCambioAceite->id, $servicioFrenos->id]);

        collect([
            ['nombre' => 'Bronce', 'slug' => 'bronce', 'puntos_minimos' => 0, 'descuento_porcentaje' => 0, 'color' => '#c77a22', 'icono' => 'medalla', 'orden' => 1],
            ['nombre' => 'Plata', 'slug' => 'plata', 'puntos_minimos' => 500, 'descuento_porcentaje' => 5, 'color' => '#c6cbd3', 'icono' => 'estrella', 'orden' => 2],
            ['nombre' => 'Oro', 'slug' => 'oro', 'puntos_minimos' => 2000, 'descuento_porcentaje' => 10, 'color' => '#f0c420', 'icono' => 'corona', 'orden' => 3],
            ['nombre' => 'Platino', 'slug' => 'platino', 'puntos_minimos' => 5000, 'descuento_porcentaje' => 15, 'color' => '#d8dbe2', 'icono' => 'sparkles', 'orden' => 4],
        ])->each(fn (array $nivel) => NivelFidelidad::query()->updateOrCreate(['slug' => $nivel['slug']], $nivel));

        collect([
            ['nombre' => 'Primer Servicio', 'descripcion' => 'Completaste tu primer servicio', 'criterio' => 'primer_servicio', 'icono' => 'medalla', 'orden' => 1],
            ['nombre' => 'Cliente Frecuente', 'descripcion' => '5 servicios completados', 'criterio' => 'cinco_servicios', 'icono' => 'estrella', 'orden' => 2],
            ['nombre' => 'Cliente VIP', 'descripcion' => '10 servicios completados', 'criterio' => 'diez_servicios', 'icono' => 'corona', 'orden' => 3],
            ['nombre' => 'Opinion Valiosa', 'descripcion' => 'Dejaste tu primera resena', 'criterio' => 'primera_resena', 'icono' => 'documento', 'orden' => 4],
            ['nombre' => 'Embajador', 'descripcion' => 'Referiste a un amigo', 'criterio' => 'referido', 'icono' => 'trofeo', 'orden' => 5],
            ['nombre' => 'Madrugador', 'descripcion' => 'Agendaste antes de las 8am', 'criterio' => 'cita_temprana', 'icono' => 'reloj', 'orden' => 6],
        ])->each(fn (array $insignia) => Insignia::query()->updateOrCreate(['criterio' => $insignia['criterio']], $insignia));

        $usuario->refresh();
        $usuario->vehiculos()->delete();
        $usuario->citas()->delete();
        $usuario->cotizaciones()->delete();
        $usuario->ordenesTrabajo()->delete();
        $usuario->movimientosPuntos()->delete();
        $usuario->insignias()->delete();
    }
}
