@extends('layouts.portal', ['titulo' => 'Carnet de Salud - DIDASA'])

@section('contenido')
    <section class="py-10 sm:py-12">
        <div class="contenedor-portal">
            <a href="{{ route('vehiculos.index') }}" class="inline-flex items-center gap-3 text-[16px] font-semibold text-slate-900 transition hover:text-didasa-rojo">
                <x-icono nombre="flecha-izquierda" clase="h-5 w-5" /> Volver
            </a>

            <div class="tarjeta-portal mt-8 overflow-hidden">
                <div class="bg-[#1b2538] px-6 py-8 text-white sm:px-8 sm:py-10">
                    <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
                        <div class="flex items-start gap-5">
                            <div class="flex h-16 w-16 items-center justify-center rounded-[22px] bg-white/10 text-white">
                                <x-icono nombre="salud" clase="h-9 w-9" />
                            </div>
                            <div>
                                <h1 class="text-[36px] font-extrabold tracking-tight sm:text-[44px]">{{ $vehiculo->marca }} {{ $vehiculo->modelo }} {{ $vehiculo->anio }}</h1>
                                <p class="mt-2 text-[18px] text-slate-300">Placa: {{ $vehiculo->placa }}</p>
                                <div class="mt-5 inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-2 text-[14px] font-semibold text-white">
                                    <x-icono nombre="salud" clase="h-4 w-4 text-didasa-rojo" />
                                    Carnet de Salud Digital
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('vehiculos.carnet.pdf', $vehiculo) }}" class="boton-terciario-oscuro min-h-[52px] rounded-[18px] text-[15px]">
                            <x-icono nombre="descargar" clase="h-5 w-5" /> Exportar PDF
                        </a>
                    </div>
                </div>
            </div>

            <div class="mt-8 grid gap-8 xl:grid-cols-[minmax(0,1fr)_360px]">
                <div>
                    <div class="flex items-center gap-3 text-[18px] font-extrabold text-slate-950 sm:text-[20px]"><x-icono nombre="llave" clase="h-5 w-5" /> Historial de Servicios</div>
                    <div class="mt-5 tarjeta-portal p-6 sm:p-7">
                        @if ($historialServicios->isEmpty())
                            <div class="estado-vacio min-h-[260px] border-slate-200 bg-slate-50">
                                <x-icono nombre="llave" clase="h-14 w-14 text-slate-300" />
                                <p class="mt-4 text-[18px] font-medium text-didasa-textoSuave">Sin historial de servicios aun</p>
                            </div>
                        @else
                            <div class="space-y-4">
                                @foreach ($historialServicios as $servicio)
                                    <article class="rounded-[20px] border border-slate-200 p-5">
                                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                            <div>
                                                <h2 class="text-[18px] font-bold text-slate-950">{{ $servicio['titulo'] }}</h2>
                                                <p class="mt-1 text-[15px] text-didasa-textoSuave">{{ $servicio['descripcion'] }}</p>
                                            </div>
                                            <div class="text-right">
                                                <div class="text-[14px] font-semibold text-slate-400">{{ $servicio['fecha'] }}</div>
                                                <div class="mt-2 inline-flex rounded-full bg-slate-100 px-3 py-1 text-[12px] font-bold uppercase tracking-[0.18em] text-slate-700">{{ str_replace('_', ' ', $servicio['estado']) }}</div>
                                            </div>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <div class="space-y-8">
                    <div>
                        <div class="flex items-center gap-3 text-[18px] font-extrabold text-slate-950 sm:text-[20px]"><x-icono nombre="reloj" clase="h-5 w-5" /> Recordatorios</div>
                        <div class="mt-5 tarjeta-portal p-6">
                            @if ($recordatorios->isEmpty())
                                <div class="estado-vacio min-h-[220px] border-slate-200 bg-slate-50">
                                    <x-icono nombre="check-circle" clase="h-12 w-12 text-slate-300" />
                                    <p class="mt-4 text-[18px] font-medium text-didasa-textoSuave">Sin recordatorios pendientes</p>
                                </div>
                            @else
                                <div class="space-y-3">
                                    @foreach ($recordatorios as $recordatorio)
                                        <div class="rounded-[18px] bg-slate-50 px-4 py-4 text-[15px] leading-7 text-didasa-textoSuave">{{ $recordatorio }}</div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="tarjeta-portal p-6">
                        <div class="text-[18px] font-extrabold text-slate-950">Resumen del Vehiculo</div>
                        <dl class="mt-5 space-y-4 text-[15px] text-didasa-textoSuave">
                            <div class="flex items-center justify-between gap-4"><dt>Estado general</dt><dd class="text-right font-semibold text-slate-900">{{ $estadoGeneral }}</dd></div>
                            <div class="flex items-center justify-between gap-4"><dt>Proxima revision</dt><dd class="text-right font-semibold text-slate-900">{{ $proximaRevision }}</dd></div>
                            <div class="flex items-center justify-between gap-4"><dt>Kilometraje actual</dt><dd class="text-right font-semibold text-slate-900">{{ number_format($vehiculo->kilometraje) }} km</dd></div>
                            <div class="flex items-center justify-between gap-4"><dt>Cotizaciones relacionadas</dt><dd class="text-right font-semibold text-slate-900">{{ $cotizacionesRelacionadas->count() }}</dd></div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
