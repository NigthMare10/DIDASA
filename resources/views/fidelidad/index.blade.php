@extends('layouts.portal', ['titulo' => 'Fidelidad - DIDASA'])

@section('contenido')
    <section class="py-8 sm:py-10">
        <div class="contenedor-portal grid gap-6 xl:grid-cols-[minmax(0,1fr)_420px]">
            <div class="space-y-8">
                <div class="tarjeta-portal overflow-hidden bg-[linear-gradient(135deg,#fff8ef_0%,#fff_82%)] p-6 sm:p-8">
                    <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
                        <div class="flex gap-5">
                            <div class="flex h-24 w-24 shrink-0 items-center justify-center rounded-[28px] bg-[#f7dfbe] text-[#c77a22]">
                                <x-icono nombre="medalla" clase="h-11 w-11" />
                            </div>
                            <div class="min-w-0">
                                <div class="text-[15px] text-didasa-textoSuave">Tu nivel actual</div>
                                <div class="mt-2 text-[46px] font-extrabold tracking-tight text-[#c77a22] sm:text-[56px]">{{ $nivelActual->nombre }}</div>
                                <div class="mt-2 text-[16px] text-didasa-textoSuave">{{ $nivelActual->descuento_porcentaje }}% de descuento en servicios</div>
                            </div>
                        </div>
                        <div class="text-right text-[15px] text-didasa-textoSuave">
                            @if ($siguienteNivel)
                                <div>{{ $siguienteNivel->puntos_minimos }} para {{ $siguienteNivel->nombre }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-8 flex items-center justify-between gap-4 text-[18px] font-bold text-slate-950">
                        <span>{{ $puntos }} puntos</span>
                        @if ($siguienteNivel)
                            <span>{{ max($siguienteNivel->puntos_minimos - $puntos, 0) }} por alcanzar</span>
                        @endif
                    </div>
                    <div class="mt-4 h-4 rounded-full bg-rose-100">
                        @php($tope = max($siguienteNivel?->puntos_minimos ?? max($puntos, 1), 1))
                        <div class="h-4 rounded-full bg-rose-200" style="width: {{ min(($puntos / $tope) * 100, 100) }}%;"></div>
                    </div>
                </div>

                <div>
                    <h2 class="text-[30px] font-extrabold tracking-tight text-slate-950 sm:text-[34px]">Niveles del Programa</h2>
                    <div class="mt-5 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                        @foreach ($niveles as $nivel)
                            <article class="tarjeta-portal min-h-[290px] p-6 {{ $nivelActual->id === $nivel->id ? 'border-2 border-slate-950' : '' }}">
                                <div class="text-center">
                                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full {{ $nivel->slug === 'bronce' ? 'text-[#c77a22]' : ($nivel->slug === 'oro' ? 'text-[#f0c420]' : 'text-slate-300') }}">
                                        <x-icono :nombre="$nivel->icono ?: 'medalla'" clase="h-10 w-10" />
                                    </div>
                                    <div class="mt-5 text-[24px] font-extrabold tracking-tight {{ $nivel->slug === 'bronce' ? 'text-[#c77a22]' : ($nivel->slug === 'oro' ? 'text-[#f0c420]' : 'text-slate-300') }}">{{ $nivel->nombre }}</div>
                                    <div class="mt-3 text-[16px] text-didasa-textoSuave">{{ $nivel->puntos_minimos }}+ pts</div>
                                    <div class="mt-3 text-[16px] font-bold text-slate-950">{{ $nivel->descuento_porcentaje }}% descuento</div>
                                </div>
                                @if ($nivelActual->id === $nivel->id)
                                    <div class="mt-6 text-center"><span class="badge-nivel">Actual</span></div>
                                @endif
                            </article>
                        @endforeach
                    </div>
                </div>

                <div>
                    <h2 class="text-[30px] font-extrabold tracking-tight text-slate-950 sm:text-[34px]">Historial de Puntos</h2>
                    @if ($historial->isEmpty())
                        <div class="estado-vacio mt-5 min-h-[260px] border-slate-200 bg-white text-[22px] text-didasa-textoSuave">Sin transacciones aun</div>
                    @else
                        <div class="mt-5 space-y-4">
                            @foreach ($historial as $movimiento)
                                <div class="tarjeta-portal flex items-center justify-between gap-4 px-6 py-5">
                                    <div>
                                        <div class="text-[17px] font-bold text-slate-950">{{ $movimiento->descripcion }}</div>
                                        <div class="mt-1 text-[14px] text-didasa-textoSuave">{{ $movimiento->created_at->translatedFormat('d M Y H:i') }}</div>
                                    </div>
                                    <div class="text-[22px] font-extrabold tracking-tight {{ $movimiento->puntos >= 0 ? 'text-emerald-500' : 'text-rose-500' }}">{{ $movimiento->puntos >= 0 ? '+' : '' }}{{ $movimiento->puntos }} pts</div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="space-y-6 xl:sticky xl:top-[118px] xl:self-start">
                <div class="tarjeta-portal p-6 sm:p-8">
                    <div class="flex items-center gap-3 text-[28px] font-extrabold tracking-tight text-slate-950"><x-icono nombre="trofeo" clase="h-7 w-7" /> Insignias</div>
                    <div class="mt-8 grid grid-cols-2 gap-4">
                        @php($obtenidas = $insignias->pluck('insignia_id')->all())
                        @foreach ($catalogoInsignias as $insignia)
                            @php($activa = in_array($insignia->id, $obtenidas, true))
                            <article class="rounded-[20px] border border-slate-200 p-4 {{ $activa ? 'bg-white' : 'bg-slate-50 opacity-40' }}">
                                <div class="text-[16px] font-extrabold tracking-tight text-slate-950">{{ $insignia->nombre }}</div>
                                <p class="mt-2 text-[13px] leading-6 text-didasa-textoSuave">{{ $insignia->descripcion }}</p>
                            </article>
                        @endforeach
                    </div>
                </div>

                <div class="tarjeta-portal p-6 sm:p-8">
                    <h2 class="text-[28px] font-extrabold tracking-tight text-slate-950">Como ganar puntos</h2>
                    <div class="mt-7 space-y-5">
                        @foreach ($gananciasPuntos as $ganancia)
                            <div class="flex items-center justify-between gap-4 text-[18px]">
                                <span class="text-slate-950">{{ $ganancia['concepto'] }}</span>
                                <span class="font-extrabold text-emerald-500">+{{ $ganancia['puntos'] }} pts</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
