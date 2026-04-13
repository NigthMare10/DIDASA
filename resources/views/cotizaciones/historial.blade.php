@extends('layouts.portal', ['titulo' => 'Mis Cotizaciones - DIDASA'])

@section('contenido')
    <section class="bloque-hero-pagina">
        <div class="contenedor-portal">
            <h1 class="titulo-pagina">Mis Cotizaciones</h1>
            <p class="subtitulo-pagina">Revisa y aprueba tus cotizaciones</p>
        </div>
    </section>

    <section class="py-10 sm:py-12">
        <div class="contenedor-portal space-y-6">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-[15px] text-didasa-textoSuave">Consulta el historial y decide si apruebas o rechazas cotizaciones pendientes.</p>
                <a href="{{ route('cotizaciones.index') }}" class="boton-primario w-fit text-[14px]">Nueva Cotizacion</a>
            </div>

            @if ($cotizaciones->isEmpty())
                <div class="estado-vacio min-h-[300px]">
                    <x-icono nombre="documento" clase="h-14 w-14 text-slate-300" />
                    <h2 class="mt-5 text-[30px] font-extrabold tracking-tight text-slate-950">Sin cotizaciones registradas</h2>
                    <p class="mt-2 text-[16px] text-didasa-textoSuave">Aun no has enviado cotizaciones desde el portal.</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach ($cotizaciones as $cotizacion)
                        @php($estado = $cotizacion->estado)
                        @php($estadoTexto = match ($estado) {
                            'aprobada' => 'Aprobada',
                            'rechazada' => 'Rechazada',
                            default => 'Pendiente',
                        })
                        @php($badgeClase = match ($estado) {
                            'aprobada' => 'bg-emerald-100 text-emerald-700',
                            'rechazada' => 'bg-rose-100 text-rose-600',
                            default => 'bg-amber-100 text-amber-700',
                        })
                        <article class="tarjeta-portal px-5 py-5 sm:px-7 sm:py-6">
                            <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                                <div class="flex min-w-0 items-center gap-4 sm:gap-5">
                                    <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-[22px] bg-didasa-rojo text-white">
                                        <x-icono nombre="documento" clase="h-8 w-8" />
                                    </div>
                                    <div class="min-w-0">
                                        <div class="text-[14px] font-semibold uppercase tracking-[0.28em] text-slate-400">{{ $cotizacion->numero_cotizacion }}</div>
                                        <h2 class="mt-1 text-[24px] font-extrabold tracking-tight text-slate-950">Cotizacion #{{ $loop->iteration }}</h2>
                                        <p class="mt-1 text-[16px] text-didasa-textoSuave">{{ optional($cotizacion->created_at)->translatedFormat('d \d\e F \d\e Y') }}</p>
                                    </div>
                                </div>

                                <div class="flex flex-col gap-4 lg:items-end">
                                    <div class="text-[18px] font-extrabold text-didasa-rojo sm:text-[20px]">L. {{ number_format($cotizacion->total, 2) }}</div>
                                    <div class="inline-flex w-fit rounded-full px-3 py-1 text-[13px] font-bold {{ $badgeClase }}">{{ $estadoTexto }}</div>
                                    @if ($estado === 'enviada' || $estado === 'pendiente')
                                        <div class="flex flex-wrap gap-3">
                                            <form method="POST" action="{{ route('cotizaciones.estado', $cotizacion) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="estado" value="aprobada">
                                                <button class="inline-flex min-h-[46px] items-center justify-center gap-2 rounded-[16px] bg-emerald-600 px-5 text-[15px] font-bold text-white transition hover:bg-emerald-700"><x-icono nombre="check-circle" clase="h-4 w-4" /> Aprobar</button>
                                            </form>
                                            <form method="POST" action="{{ route('cotizaciones.estado', $cotizacion) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="estado" value="rechazada">
                                                <button class="inline-flex min-h-[46px] items-center justify-center gap-2 rounded-[16px] border border-rose-300 bg-white px-5 text-[15px] font-bold text-rose-600 transition hover:bg-rose-50"><x-icono nombre="x" clase="h-4 w-4" /> Rechazar</button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection
