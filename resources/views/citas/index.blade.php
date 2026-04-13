@extends('layouts.portal', ['titulo' => 'Agendar - DIDASA'])

@php($calendarioInicialJson = json_encode($calendarioInicial, JSON_UNESCAPED_UNICODE))

@section('contenido')
    <section class="bloque-hero-pagina">
        <div class="contenedor-portal">
            <h1 class="titulo-pagina">Agendar Cita</h1>
            <p class="subtitulo-pagina">Selecciona fecha, hora y vehículo para tu cita</p>
        </div>
    </section>

    <section class="py-8 sm:py-10">
        <div class="contenedor-portal" x-data="agendarPortal({
            calendarioInicial: @js($calendarioInicial),
            mesInicial: @js($mesInicial),
            fechaInicial: @js(old('fecha', $fechaSeleccionada)),
            horaInicial: @js(old('hora', '')),
            vehiculoInicial: @js(old('vehiculoId', '')),
        })">
            <div class="mb-6 flex flex-col gap-4 sm:mb-8 lg:flex-row lg:items-center lg:justify-end">
                <a href="{{ route('citas.historial') }}" class="boton-secundario w-fit text-[14px]">Ver mis citas</a>
            </div>

            <div class="grid gap-8 xl:grid-cols-[minmax(0,1fr)_392px]">
                <form id="formulario-cita" method="POST" action="{{ route('citas.store') }}" class="space-y-6 min-w-0">
                    @csrf
                    <input type="hidden" name="hora" x-model="hora">
                    <input type="hidden" name="fecha" x-model="fechaSeleccionada">

                    <div class="tarjeta-portal p-6 sm:p-8">
                        <div class="flex items-center gap-3 text-[22px] font-extrabold tracking-tight text-slate-950 sm:text-[24px]"><x-icono nombre="vehiculo" clase="h-6 w-6" /> Vehiculo</div>
                        <div class="mt-6 max-w-[470px]">
                            <select class="select-portal" name="vehiculoId" x-model="vehiculoId">
                                <option value="">Seleccionar vehiculo</option>
                                @foreach ($vehiculos as $vehiculo)
                                    <option value="{{ $vehiculo->id }}">{{ $vehiculo->marca }} {{ $vehiculo->modelo }} - {{ $vehiculo->placa }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="tarjeta-portal p-6 sm:p-8">
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                            <div class="flex items-center gap-3 text-[22px] font-extrabold tracking-tight text-slate-950 sm:text-[24px]"><x-icono nombre="calendario" clase="h-6 w-6" /> Fecha</div>
                            <div class="flex items-center gap-2 text-[15px] font-semibold text-slate-700">
                                <button type="button" @click="cambiarMes(calendario.mesAnterior)" class="rounded-full border border-slate-200 p-2.5 hover:bg-slate-100">&lsaquo;</button>
                                <span x-text="calendario.tituloMes"></span>
                                <button type="button" @click="cambiarMes(calendario.mesSiguiente)" class="rounded-full border border-slate-200 p-2.5 hover:bg-slate-100">&rsaquo;</button>
                            </div>
                        </div>

                        <div class="mx-auto mt-6 max-w-[380px] rounded-[24px] border border-slate-200 p-5">
                            <div class="grid grid-cols-7 gap-2 text-center text-[13px] font-medium text-didasa-textoSuave sm:text-[14px]">
                                <template x-for="dia in ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa']" :key="dia">
                                    <div x-text="dia"></div>
                                </template>
                            </div>

                            <div class="mt-4 space-y-2 text-center text-[16px] sm:text-[18px]">
                                <template x-for="(semana, indiceSemana) in calendario.semanas" :key="indiceSemana">
                                    <div class="grid grid-cols-7 gap-2">
                                        <template x-for="dia in semana" :key="dia.fecha">
                                            <button type="button" @click="seleccionarFecha(dia)" class="flex h-11 items-center justify-center rounded-[14px] font-medium transition" :class="claseDia(dia)" x-bind:data-fecha="dia.fecha" x-bind:data-seleccionado="fechaSeleccionada === dia.fecha ? 'true' : 'false'" x-bind:data-disponible="dia.esDelMesActual && dia.esDiaLaboral && !dia.esPasado ? 'true' : 'false'" x-text="dia.dia"></button>
                                        </template>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <div class="tarjeta-portal p-6 sm:p-8">
                        <div class="flex items-center gap-3 text-[22px] font-extrabold tracking-tight text-slate-950 sm:text-[24px]"><x-icono nombre="reloj" clase="h-6 w-6" /> Hora</div>
                        <div class="mt-6 grid gap-3 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
                            <template x-for="horaDisponible in horasDisponibles" :key="horaDisponible">
                                <button type="button" @click="hora = horaDisponible" class="rounded-[16px] border px-3 py-3 text-[15px] font-bold transition" :class="hora === horaDisponible ? 'border-didasa-rojo bg-didasa-rojo text-white' : 'border-slate-200 bg-white text-slate-900 hover:bg-slate-100'" x-bind:data-hora="horaDisponible" x-text="horaDisponible"></button>
                            </template>
                        </div>
                    </div>

                    <div>
                        <label class="mb-3 block text-[15px] font-bold text-slate-900">Notas</label>
                        <textarea class="textarea-portal min-h-[112px]" name="notas" placeholder="Describe brevemente el servicio que necesitas...">{{ old('notas') }}</textarea>
                    </div>

                    @if ($errors->any())
                        <div class="rounded-[18px] border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-700">{{ $errors->first() }}</div>
                    @endif
                </form>

                <aside class="tarjeta-portal h-fit self-start p-6 sm:p-8 xl:sticky" style="top: calc(var(--altura-navbar) + 22px);">
                    <div class="text-[28px] font-extrabold tracking-tight text-slate-950">Resumen de Cita</div>
                    <dl class="mt-8 space-y-4 text-[17px] text-didasa-textoSuave">
                        <div class="flex items-center justify-between gap-4"><dt>Vehiculo</dt><dd class="max-w-[180px] text-right font-semibold text-slate-900" x-text="vehiculoSeleccionadoTexto"></dd></div>
                        <div class="flex items-center justify-between gap-4"><dt>Fecha</dt><dd class="text-right font-semibold text-slate-900" x-text="fechaFormateada"></dd></div>
                        <div class="flex items-center justify-between gap-4"><dt>Hora</dt><dd class="text-right font-semibold text-slate-900" x-text="hora || '-' "></dd></div>
                    </dl>
                    <button type="button" @click="document.getElementById('formulario-cita').submit()" class="boton-primario mt-8 w-full text-[15px]" :disabled="!vehiculoId || !fechaSeleccionada || !hora">
                        <x-icono nombre="plane" clase="h-5 w-5" /> Confirmar Cita
                    </button>
                </aside>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        function agendarPortal(configuracion) {
            return {
                calendario: configuracion.calendarioInicial,
                fechaSeleccionada: configuracion.fechaInicial,
                hora: configuracion.horaInicial,
                vehiculoId: configuracion.vehiculoInicial,
                cargandoMes: false,
                get horasDisponibles() {
                    return this.calendario.horasPorFecha?.[this.fechaSeleccionada] ?? [];
                },
                get vehiculoSeleccionadoTexto() {
                    const selector = document.querySelector('select[name="vehiculoId"]');
                    return this.vehiculoId && selector ? selector.selectedOptions[0]?.text ?? '-' : '-';
                },
                get fechaFormateada() {
                    if (!this.fechaSeleccionada) return '-';
                    const fecha = new Date(`${this.fechaSeleccionada}T12:00:00`);
                    return fecha.toLocaleDateString('es-HN', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
                },
                async cambiarMes(mes) {
                    this.cargandoMes = true;
                    const respuesta = await fetch(`{{ route('citas.disponibilidad') }}?mes=${mes}`, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    });
                    this.calendario = await respuesta.json();
                    this.cargandoMes = false;
                    if (!this.calendario.horasPorFecha[this.fechaSeleccionada]) {
                        this.fechaSeleccionada = this.primeraFechaDisponible();
                        this.hora = '';
                    }
                },
                primeraFechaDisponible() {
                    for (const [fecha, horas] of Object.entries(this.calendario.horasPorFecha)) {
                        if (Array.isArray(horas) && horas.length > 0) return fecha;
                    }
                    return '';
                },
                seleccionarFecha(dia) {
                    if (!dia.esDelMesActual || !dia.esDiaLaboral || dia.esPasado) return;
                    this.fechaSeleccionada = dia.fecha;
                    if (!this.horasDisponibles.includes(this.hora)) {
                        this.hora = '';
                    }
                },
                claseDia(dia) {
                    if (!dia.esDelMesActual || !dia.esDiaLaboral || dia.esPasado) {
                        return 'text-slate-300';
                    }

                    if (this.fechaSeleccionada === dia.fecha) {
                        return 'bg-didasa-rojo text-white';
                    }

                    return 'bg-slate-100 text-slate-900 hover:bg-slate-200';
                },
                init() {
                    if (!this.fechaSeleccionada) {
                        this.fechaSeleccionada = this.primeraFechaDisponible();
                    }
                },
            }
        }
    </script>
@endpush
