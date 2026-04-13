<?php

namespace App\Providers;

use App\Modulos\OrdenesTrabajo\Models\OrdenTrabajo;
use App\Modulos\OrdenesTrabajo\Policies\OrdenTrabajoPolicy;
use App\Modulos\Vehiculos\Models\Vehiculo;
use App\Modulos\Vehiculos\Policies\VehiculoPolicy;
use Carbon\CarbonImmutable;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        CarbonImmutable::setLocale('es');

        Gate::policy(Vehiculo::class, VehiculoPolicy::class);
        Gate::policy(OrdenTrabajo::class, OrdenTrabajoPolicy::class);

        RateLimiter::for('vehiculos', function (Request $request) {
            return Limit::perMinute(12)->by((string) $request->user()?->id ?: $request->ip());
        });

        RateLimiter::for('cotizaciones', function (Request $request) {
            return Limit::perMinute(8)->by((string) $request->user()?->id ?: $request->ip());
        });

        RateLimiter::for('citas', function (Request $request) {
            return Limit::perMinute(6)->by((string) $request->user()?->id ?: $request->ip());
        });
    }
}
