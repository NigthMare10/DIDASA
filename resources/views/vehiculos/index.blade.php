@extends('layouts.portal', ['titulo' => 'Mis Vehiculos - DIDASA'])

@section('contenido')
    <section class="py-10 sm:py-12" x-data="{ modalAbierto: {{ $errors->any() ? 'true' : 'false' }} }">
        <div class="contenedor-portal">
            <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="text-[44px] font-extrabold tracking-tight text-slate-950 sm:text-[54px] lg:text-[64px]">Mis Vehiculos</h1>
                    <p class="mt-2 text-[17px] text-didasa-textoSuave sm:text-[18px]">Gestiona tus vehiculos y accede a su carnet de salud.</p>
                </div>
                <button type="button" @click="modalAbierto = true" class="boton-primario h-[54px] min-w-[220px] rounded-[20px] text-[15px] sm:min-w-[250px]">
                    <x-icono nombre="plus" clase="h-5 w-5" />
                    Agregar Vehiculo
                </button>
            </div>

            @if ($vehiculos->isEmpty())
                <div class="estado-vacio mt-10">
                    <x-icono nombre="vehiculo" clase="h-14 w-14 text-slate-400" />
                    <h2 class="mt-5 text-[32px] font-extrabold tracking-tight text-slate-950">Sin vehiculos registrados</h2>
                    <p class="mt-2 text-[16px] text-didasa-textoSuave sm:text-[18px]">Agrega tu primer vehiculo para comenzar.</p>
                    <button type="button" @click="modalAbierto = true" class="boton-secundario mt-7 text-[15px]"><x-icono nombre="plus" clase="h-4 w-4" /> Agregar Vehiculo</button>
                </div>
            @else
                <div class="mt-10 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($vehiculos as $vehiculo)
                        <article class="tarjeta-portal tarjeta-hover flex h-full flex-col p-7">
                            <div class="flex items-start justify-between gap-5">
                                <div>
                                    <div class="text-[14px] font-bold uppercase tracking-[0.32em] text-slate-400">{{ $vehiculo->placa }}</div>
                                    <h2 class="mt-4 text-[28px] font-extrabold tracking-tight text-slate-950">{{ $vehiculo->marca }} {{ $vehiculo->modelo }}</h2>
                                    <p class="mt-2 text-[16px] text-didasa-textoSuave">{{ $vehiculo->anio }} <span class="px-1">&middot;</span> {{ $vehiculo->color }}</p>
                                </div>
                                <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-[20px] bg-slate-100 text-slate-500">
                                    <x-icono nombre="vehiculo" clase="h-8 w-8" />
                                </div>
                            </div>

                            <dl class="mt-8 grid grid-cols-2 gap-6 text-[15px] leading-7 text-didasa-textoSuave">
                                <div>
                                    <dt class="font-bold text-slate-950">Anio</dt>
                                    <dd>{{ $vehiculo->anio }}</dd>
                                </div>
                                <div>
                                    <dt class="font-bold text-slate-950">Color</dt>
                                    <dd>{{ $vehiculo->color }}</dd>
                                </div>
                                <div>
                                    <dt class="font-bold text-slate-950">Kilometraje</dt>
                                    <dd>{{ number_format($vehiculo->kilometraje) }} km</dd>
                                </div>
                                <div>
                                    <dt class="font-bold text-slate-950">VIN</dt>
                                    <dd class="linea-clamp-2">{{ $vehiculo->vin ?: 'Opcional' }}</dd>
                                </div>
                            </dl>

                            <div class="mt-7 flex items-center justify-between gap-3 border-t border-slate-100 pt-5">
                                <a href="{{ route('vehiculos.carnet', $vehiculo) }}" class="boton-secundario min-h-[48px] flex-1 justify-start rounded-[16px] px-4 text-[15px] font-semibold">
                                    <x-icono nombre="salud" clase="h-5 w-5" />
                                    Carnet de Salud
                                </a>
                                <form method="POST" action="{{ route('vehiculos.destroy', $vehiculo) }}" onsubmit="return confirm('Se eliminara este vehiculo y su historial relacionado.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex h-12 w-12 items-center justify-center rounded-[16px] text-didasa-rojo transition hover:bg-red-50">
                                        <x-icono nombre="basura" clase="h-5 w-5" />
                                    </button>
                                </form>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>

        <div x-show="modalAbierto" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/55 p-4">
            <div @click.outside="modalAbierto = false" class="w-full max-w-[660px] rounded-[28px] bg-white shadow-2xl">
                <div class="flex items-start justify-between border-b border-slate-200 px-6 py-5 sm:px-8 sm:py-6">
                    <h2 class="text-[34px] font-extrabold tracking-tight text-slate-950 sm:text-[40px]">Registrar Nuevo Vehiculo</h2>
                    <button type="button" @click="modalAbierto = false" class="rounded-full p-2 text-slate-500 hover:bg-slate-100"><x-icono nombre="x" clase="h-5 w-5" /></button>
                </div>
                <form method="POST" action="{{ route('vehiculos.store') }}" class="px-6 py-6 sm:px-8">
                    @csrf
                    <div class="grid gap-5 md:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-[15px] font-bold text-slate-900">Marca</label>
                            <input class="input-portal" name="marca" value="{{ old('marca') }}" placeholder="Toyota">
                        </div>
                        <div>
                            <label class="mb-2 block text-[15px] font-bold text-slate-900">Modelo</label>
                            <input class="input-portal" name="modelo" value="{{ old('modelo') }}" placeholder="Hilux">
                        </div>
                        <div>
                            <label class="mb-2 block text-[15px] font-bold text-slate-900">Anio</label>
                            <input class="input-portal" name="anio" type="number" value="{{ old('anio') }}" placeholder="2024">
                        </div>
                        <div>
                            <label class="mb-2 block text-[15px] font-bold text-slate-900">Placa</label>
                            <input class="input-portal" name="placa" value="{{ old('placa') }}" placeholder="AAA-0000">
                        </div>
                        <div>
                            <label class="mb-2 block text-[15px] font-bold text-slate-900">VIN</label>
                            <input class="input-portal" name="vin" value="{{ old('vin') }}" placeholder="Opcional">
                        </div>
                        <div>
                            <label class="mb-2 block text-[15px] font-bold text-slate-900">Kilometraje</label>
                            <input class="input-portal" name="kilometraje" type="number" value="{{ old('kilometraje', 0) }}" placeholder="0">
                        </div>
                    </div>
                    <div class="mt-5">
                        <label class="mb-2 block text-[15px] font-bold text-slate-900">Color</label>
                        <input class="input-portal" name="color" value="{{ old('color') }}" placeholder="Blanco">
                    </div>
                    @if ($errors->any())
                        <div class="mt-5 rounded-[18px] border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-700">{{ $errors->first() }}</div>
                    @endif
                    <div class="mt-8 border-t border-slate-200 pt-5">
                        <button class="boton-primario w-full rounded-[18px] text-[15px]">Registrar Vehiculo</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
