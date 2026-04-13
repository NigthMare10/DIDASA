@extends('layouts.portal', ['titulo' => 'Mis Ordenes - DIDASA'])

@section('contenido')
    <section class="bloque-hero-pagina">
        <div class="contenedor-portal">
            <h1 class="titulo-pagina">Mis Ordenes de Trabajo</h1>
            <p class="subtitulo-pagina">Sigue el estado de tus reparaciones</p>
        </div>
    </section>

    <section class="py-10 sm:py-12">
        <div class="contenedor-portal">
            @if ($ordenes->isEmpty())
                <div class="estado-vacio">
                    <x-icono nombre="portapapeles" clase="h-16 w-16 text-slate-300" />
                    <h2 class="mt-6 text-[30px] font-extrabold tracking-tight text-slate-950">Sin ordenes de trabajo</h2>
                </div>
            @else
                <div class="space-y-6">
                    @foreach ($ordenes as $orden)
                        <article class="tarjeta-portal overflow-hidden tarjeta-hover">
                            <div class="grid gap-0 lg:grid-cols-[340px_minmax(0,1fr)]">
                                <div class="bg-[#1b2538] p-8 text-white">
                                    <div class="text-sm font-bold uppercase tracking-[0.35em] text-slate-400">{{ $orden->numero_orden }}</div>
                                    <h2 class="mt-4 text-[28px] font-extrabold tracking-tight">{{ $orden->vehiculo->marca }} {{ $orden->vehiculo->modelo }}</h2>
                                    <p class="mt-3 text-[15px] leading-7 text-slate-300">{{ $orden->descripcion ?: 'Seguimiento generado desde tu cita web.' }}</p>
                                    <div class="mt-8 inline-flex rounded-full bg-white/10 px-4 py-2 text-[12px] font-bold uppercase tracking-[0.24em] text-white">{{ str_replace('_', ' ', $orden->estado) }}</div>
                                </div>
                                <div class="p-6 sm:p-8">
                                    <div class="mb-6 flex items-center justify-between gap-4">
                                        <div>
                                            <h3 class="text-[26px] font-extrabold tracking-tight text-slate-950">Seguimiento</h3>
                                            <p class="mt-2 text-[15px] text-didasa-textoSuave">Progreso actual: {{ $orden->progreso }}%</p>
                                        </div>
                                        <div class="text-[28px] font-extrabold tracking-tight text-didasa-rojo">{{ $orden->progreso }}%</div>
                                    </div>
                                    <div class="h-3 rounded-full bg-slate-100">
                                        <div class="h-3 rounded-full bg-didasa-rojo" style="width: {{ $orden->progreso }}%;"></div>
                                    </div>
                                    <div class="mt-8 space-y-5">
                                        @foreach ($orden->eventos as $evento)
                                            <div class="flex gap-4">
                                                <div class="mt-1 flex h-10 w-10 shrink-0 items-center justify-center rounded-full {{ $evento->completado ? 'bg-didasa-rojo text-white' : 'bg-slate-100 text-slate-500' }}">
                                                    <x-icono nombre="check-circle" clase="h-5 w-5" />
                                                </div>
                                                <div>
                                                    <div class="text-[18px] font-extrabold text-slate-950">{{ $evento->titulo }}</div>
                                                    <div class="mt-1 text-[15px] leading-7 text-didasa-textoSuave">{{ $evento->descripcion }}</div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection
