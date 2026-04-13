@extends('layouts.portal', ['titulo' => 'Mis Citas - DIDASA'])

@section('contenido')
    <section class="bloque-hero-pagina">
        <div class="contenedor-portal">
            <h1 class="titulo-pagina">Mis Citas</h1>
            <p class="subtitulo-pagina">Consulta tus citas confirmadas y agendadas</p>
        </div>
    </section>

    <section class="py-10 sm:py-12">
        <div class="contenedor-portal space-y-6">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-[15px] text-didasa-textoSuave">Consulta tus citas confirmadas y agenda nuevas visitas desde el calendario visual.</p>
                <a href="{{ route('citas.index') }}" class="boton-primario w-fit text-[14px]">Agendar Nueva Cita</a>
            </div>

            @if ($citas->isEmpty())
                <div class="estado-vacio min-h-[300px]">
                    <x-icono nombre="calendario" clase="h-14 w-14 text-slate-300" />
                    <h2 class="mt-5 text-[30px] font-extrabold tracking-tight text-slate-950">Sin citas registradas</h2>
                    <p class="mt-2 text-[16px] text-didasa-textoSuave">Aun no tienes citas confirmadas en el sistema.</p>
                </div>
            @else
                <div class="grid gap-4 lg:grid-cols-2">
                    @foreach ($citas as $cita)
                        <article class="tarjeta-portal tarjeta-hover p-6">
                            <div class="flex h-full flex-col gap-5">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <div class="text-[14px] font-bold uppercase tracking-[0.24em] text-slate-400">{{ optional($cita->fecha)->translatedFormat('d M. Y') }}</div>
                                        <h2 class="mt-2 text-[24px] font-extrabold tracking-tight text-slate-950">{{ $cita->vehiculo?->marca }} {{ $cita->vehiculo?->modelo }}</h2>
                                        <p class="mt-2 text-[16px] text-didasa-textoSuave">{{ $cita->vehiculo?->placa }} <span class="px-1">&middot;</span> {{ $cita->hora }}</p>
                                    </div>
                                    <div class="inline-flex rounded-full bg-rose-100 px-3 py-1 text-[12px] font-bold uppercase tracking-[0.18em] text-didasa-rojo">{{ ucfirst($cita->estado) }}</div>
                                </div>

                                <div class="rounded-[18px] bg-slate-50 px-4 py-4 text-[15px] leading-7 text-didasa-textoSuave">
                                    {{ $cita->notas ?: 'Cita generada desde el portal DIDASA.' }}
                                </div>

                                <div class="mt-auto flex flex-wrap gap-3">
                                    @if ($cita->ordenTrabajo)
                                        <a href="{{ route('ordenes.index') }}" class="boton-secundario rounded-[16px] text-[14px]">Ver Orden</a>
                                    @endif
                                    <a href="{{ route('citas.index') }}" class="boton-secundario rounded-[16px] text-[14px]">Nueva Cita</a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection
