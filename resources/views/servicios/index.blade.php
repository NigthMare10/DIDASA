@extends('layouts.portal', ['titulo' => 'Servicios - DIDASA'])

@section('contenido')
    <section class="bloque-hero-pagina">
        <div class="contenedor-portal">
            <h1 class="titulo-pagina">Catalogo de Servicios</h1>
            <p class="subtitulo-pagina">Explora nuestros servicios y paquetes de mantenimiento</p>
        </div>
    </section>

    <section class="py-10 sm:py-12">
        <div class="contenedor-portal">
            <div class="inline-flex rounded-[18px] bg-slate-100 p-1 shadow-sm">
                <a href="{{ route('servicios.index', ['pestana' => 'servicios']) }}" class="{{ $pestanaActiva === 'servicios' ? 'bg-white shadow-sm' : '' }} inline-flex items-center gap-2 rounded-[16px] px-4 py-3 text-[15px] font-bold text-slate-900 sm:px-5">
                    <x-icono nombre="llave" clase="h-5 w-5" /> Servicios
                </a>
                <a href="{{ route('servicios.index', ['pestana' => 'paquetes']) }}" class="{{ $pestanaActiva === 'paquetes' ? 'bg-white shadow-sm' : '' }} inline-flex items-center gap-2 rounded-[16px] px-4 py-3 text-[15px] font-bold text-slate-900 sm:px-5">
                    <x-icono nombre="documento" clase="h-5 w-5" /> Paquetes
                </a>
            </div>

            @if ($pestanaActiva === 'servicios')
                @if ($servicios->isEmpty())
                    <div class="estado-vacio mt-10 text-[24px] text-didasa-textoSuave">No hay servicios disponibles aun</div>
                @else
                    <div class="mt-10 grid gap-6 lg:grid-cols-3">
                        @foreach ($servicios as $servicio)
                            <article class="tarjeta-portal tarjeta-hover p-7">
                                <h2 class="text-[24px] font-extrabold tracking-tight text-slate-950">{{ $servicio->nombre }}</h2>
                                <p class="mt-4 text-[15px] leading-8 text-didasa-textoSuave">{{ $servicio->descripcion }}</p>
                                <div class="mt-8 text-[28px] font-extrabold tracking-tight text-didasa-rojo">L. {{ number_format($servicio->precio_base, 2) }}</div>
                            </article>
                        @endforeach
                    </div>
                @endif
            @else
                @if ($paquetes->isEmpty())
                    <div class="estado-vacio mt-10 text-[24px] text-didasa-textoSuave">No hay paquetes disponibles aun</div>
                @else
                    <div class="mt-10 grid gap-6 lg:grid-cols-3">
                        @foreach ($paquetes as $paquete)
                            <article class="tarjeta-portal tarjeta-hover p-7">
                                <h2 class="text-[24px] font-extrabold tracking-tight text-slate-950">{{ $paquete->nombre }}</h2>
                                <p class="mt-4 text-[15px] leading-8 text-didasa-textoSuave">{{ $paquete->descripcion }}</p>
                                <div class="mt-8 text-[28px] font-extrabold tracking-tight text-didasa-rojo">L. {{ number_format($paquete->precio_base, 2) }}</div>
                            </article>
                        @endforeach
                    </div>
                @endif
            @endif
        </div>
    </section>
@endsection
