@extends('layouts.portal', ['titulo' => 'DIDASA Tecnicentro'])

@section('contenido')
    <section class="bg-[#1b2538] py-0 text-white">
        <div class="contenedor-portal pt-6 sm:pt-8">
            <div class="hero-oscuro px-6 py-12 sm:px-8 sm:py-14 lg:px-12 lg:py-16">
                <div class="grid items-center gap-10 lg:grid-cols-[minmax(0,640px)_1fr]">
                    <div class="min-w-0">
                        <div
                            class="mb-6 inline-flex items-center gap-2 rounded-full bg-[rgba(217,4,22,0.16)] px-4 py-2.5 text-[15px] font-semibold text-white sm:px-5">
                            <span class="text-didasa-rojo"><x-icono nombre="sparkles" clase="h-4 w-4" /></span>
                            Tecnicentro de Confianza en Honduras
                        </div>
                        <h1
                            class="max-w-[620px] text-[56px] font-extrabold leading-[0.98] tracking-[-0.04em] text-white sm:text-[68px] lg:text-[86px]">
                            Tu vehiculo merece el <span class="text-[#ef3b3c]">mejor cuidado</span>
                        </h1>
                        <p class="mt-7 max-w-[680px] text-[17px] leading-9 text-slate-300 sm:text-[18px] lg:text-[20px]">
                            Cotiza, agenda y da seguimiento a la reparacion de tu vehiculo desde cualquier lugar.
                            Transparencia total con inspeccion digital y programa de fidelidad.
                        </p>
                        <div class="mt-9 flex flex-wrap gap-3">
                            <a href="{{ auth()->check() ? route('cotizaciones.index') : route('register') }}"
                                class="boton-primario min-w-[178px] text-[15px] sm:min-w-[190px]">Cotizar Ahora <x-icono
                                    nombre="flecha-derecha" clase="h-4 w-4" /></a>
                            <a href="{{ auth()->check() ? route('citas.index') : route('login') }}"
                                class="boton-secundario min-w-[178px] border-slate-500 bg-transparent text-[15px] text-white hover:bg-white/8 hover:text-white sm:min-w-[190px]">Agendar
                                Cita</a>
                        </div>
                    </div>
                    <div class="hidden min-h-[380px] rounded-[28px] lg:block"></div>
                </div>
            </div>
        </div>
    </section>

    <section class="border-b border-slate-200 bg-white py-5 sm:py-6">
        <div class="contenedor-portal overflow-hidden">
            <div class="flex flex-wrap items-center justify-center gap-x-8 gap-y-3 lg:justify-start xl:gap-x-10">
                @foreach ($categorias as $categoria)
                    <button type="button" class="categoria-servicio-link">
                        <x-icono :nombre="$categoria['icono']" clase="h-5 w-5" />
                        <span>{{ $categoria['nombre'] }}</span>
                    </button>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-20 sm:py-24">
        <div class="contenedor-portal">
            <div class="mb-12 text-center sm:mb-14">
                <h2 class="titulo-seccion-clara mt-4">Todo lo que necesitas en un solo lugar</h2>
                <p class="mt-4 text-[17px] text-didasa-textoSuave sm:text-[18px]">Una experiencia digital completa para el
                    cuidado de tu vehiculo</p>
            </div>

            <div class="grid gap-6 lg:grid-cols-3">
                @foreach ($beneficios as $beneficio)
                    <article class="tarjeta-portal tarjeta-hover min-h-[284px] p-7 sm:p-8">
                        <div class="mb-7 flex h-16 w-16 items-center justify-center rounded-[22px] bg-didasa-rojo text-white">
                            <x-icono :nombre="$beneficio['icono']" clase="h-8 w-8" />
                        </div>
                        <h3 class="text-[24px] font-extrabold tracking-tight text-slate-950">{{ $beneficio['titulo'] }}</h3>
                        <p class="mt-5 text-[16px] leading-8 text-didasa-textoSuave sm:text-[17px]">
                            {{ $beneficio['descripcion'] }}
                        </p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-white py-20 sm:py-24">
        <div class="contenedor-portal text-center">
            <h2 class="titulo-seccion-clara">Como funciona</h2>
            <p class="mt-4 text-[17px] text-didasa-textoSuave sm:text-[18px]">Proceso simple y transparente en 4 pasos</p>

            <div class="mt-14 grid gap-8 lg:grid-cols-4 lg:gap-10">
                @foreach ($pasos as $paso)
                    <div class="px-2">
                        <div
                            class="mx-auto flex h-[74px] w-[74px] items-center justify-center rounded-[24px] bg-didasa-rojo text-white shadow-sm">
                            <x-icono :nombre="$paso['icono']" clase="h-8 w-8" />
                        </div>
                        <div class="mt-5 text-[26px] font-extrabold text-didasa-rojo">{{ $paso['numero'] }}</div>
                        <h3 class="mt-3 text-[24px] font-extrabold tracking-tight text-slate-950">{{ $paso['titulo'] }}</h3>
                        <p class="mt-4 text-[16px] leading-8 text-didasa-textoSuave">{{ $paso['descripcion'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="pb-12 pt-6 sm:pb-16">
        <div class="contenedor-portal">
            <div class="hero-oscuro px-6 py-12 text-center sm:px-10 sm:py-14 lg:px-16 lg:py-16">
                <h2 class="text-[40px] font-extrabold tracking-tight text-white sm:text-[48px] lg:text-[60px]">Comienza a
                    cuidar tu vehiculo <span class="text-[#ef3b3c]">hoy</span></h2>
                <p class="mx-auto mt-5 max-w-4xl text-[17px] leading-8 text-slate-300 sm:text-[19px]">
                    Registrate y obten acceso a cotizaciones instantaneas, seguimiento en tiempo real y nuestro programa de
                    fidelidad exclusivo.
                </p>
            </div>
        </div>
    </section>
@endsection