<?php

use App\Http\Controllers\ProfileController;
use App\Modulos\Citas\Http\Controllers\CitaController;
use App\Modulos\Cotizaciones\Http\Controllers\CotizacionController;
use App\Modulos\Fidelidad\Http\Controllers\FidelidadController;
use App\Modulos\OrdenesTrabajo\Http\Controllers\OrdenTrabajoController;
use App\Modulos\Portal\Http\Controllers\InicioController;
use App\Modulos\Servicios\Http\Controllers\CatalogoServicioController;
use App\Modulos\Vehiculos\Http\Controllers\VehiculoController;
use Illuminate\Support\Facades\Route;

Route::get('/', InicioController::class)->name('inicio');

Route::middleware('auth')->group(function () {
    Route::get('/mis-vehiculos', [VehiculoController::class, 'index'])->name('vehiculos.index');
    Route::get('/mis-vehiculos/{vehiculo}/carnet', [VehiculoController::class, 'showCarnet'])->name('vehiculos.carnet');
    Route::get('/mis-vehiculos/{vehiculo}/carnet/pdf', [VehiculoController::class, 'exportarCarnetPdf'])->name('vehiculos.carnet.pdf');
    Route::post('/mis-vehiculos', [VehiculoController::class, 'store'])
        ->middleware('throttle:vehiculos')
        ->name('vehiculos.store');
    Route::delete('/mis-vehiculos/{vehiculo}', [VehiculoController::class, 'destroy'])->name('vehiculos.destroy');

    Route::get('/servicios', [CatalogoServicioController::class, 'index'])->name('servicios.index');

    Route::get('/cotizar', [CotizacionController::class, 'index'])->name('cotizaciones.index');
    Route::get('/mis-cotizaciones', [CotizacionController::class, 'historial'])->name('cotizaciones.historial');
    Route::post('/cotizar', [CotizacionController::class, 'store'])
        ->middleware('throttle:cotizaciones')
        ->name('cotizaciones.store');
    Route::patch('/cotizar/{cotizacion}/estado', [CotizacionController::class, 'actualizarEstado'])->name('cotizaciones.estado');

    Route::get('/agendar', [CitaController::class, 'index'])->name('citas.index');
    Route::get('/agendar/disponibilidad', [CitaController::class, 'disponibilidad'])->name('citas.disponibilidad');
    Route::get('/mis-citas', [CitaController::class, 'historial'])->name('citas.historial');
    Route::post('/agendar', [CitaController::class, 'store'])
        ->middleware('throttle:citas')
        ->name('citas.store');

    Route::get('/mis-ordenes', [OrdenTrabajoController::class, 'index'])->name('ordenes.index');
    Route::get('/fidelidad', FidelidadController::class)->name('fidelidad.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/dashboard', function () {
    return redirect()->route('inicio');
})->middleware('auth')->name('dashboard');

require __DIR__.'/auth.php';
