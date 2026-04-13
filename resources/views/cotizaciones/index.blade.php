@extends('layouts.portal', ['titulo' => 'Cotizar - DIDASA'])

@php($itemsPrevios = json_decode(old('itemsJson', '[]'), true) ?: [])
@php($serviciosJson = $servicios->map(fn ($servicio) => ['id' => $servicio->id, 'descripcion' => $servicio->nombre, 'precioUnitario' => (float) $servicio->precio_base])->values())
@php($paquetesJson = $paquetes->map(fn ($paquete) => ['id' => $paquete->id, 'descripcion' => $paquete->nombre, 'precioUnitario' => (float) $paquete->precio_base])->values())

@section('contenido')
    <section class="bloque-hero-pagina">
        <div class="contenedor-portal">
            <h1 class="titulo-pagina">Cotización Inteligente</h1>
            <p class="subtitulo-pagina">Crea tu cotización con desglose detallado</p>
        </div>
    </section>

    <section class="py-8 sm:py-10">
        <div class="contenedor-portal">
            <div class="mb-6 flex flex-col gap-4 sm:mb-8 lg:flex-row lg:items-center lg:justify-end">
                <a href="{{ route('cotizaciones.historial') }}" class="boton-secundario w-fit text-[14px]">Ver mis cotizaciones</a>
            </div>

            <div class="grid gap-8 xl:grid-cols-[minmax(0,1fr)_392px]" x-data="cotizacionPortal()">
                <form id="formulario-cotizacion" method="POST" action="{{ route('cotizaciones.store') }}" class="space-y-6 min-w-0">
                    @csrf
                    <input type="hidden" name="itemsJson" :value="JSON.stringify(items)">

                    <div class="tarjeta-portal p-6 sm:p-8">
                        <h2 class="text-[22px] font-extrabold tracking-tight text-slate-950 sm:text-[24px]">1. Selecciona tu vehiculo</h2>
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
                        <h2 class="text-[22px] font-extrabold tracking-tight text-slate-950 sm:text-[24px]">2. Agrega servicios</h2>
                        <div class="mt-6 grid gap-5 xl:grid-cols-3">
                            <div>
                                <label class="mb-3 block text-[14px] font-bold text-slate-700">Servicio individual</label>
                                <select class="select-portal" x-model="servicioIdSeleccionado">
                                    <option value="">Agregar servicio</option>
                                    @foreach ($servicios as $servicio)
                                        <option value="{{ $servicio->id }}">{{ $servicio->nombre }}</option>
                                    @endforeach
                                </select>
                                <button type="button" @click="agregarServicio" class="boton-secundario mt-3 w-full text-[14px]">Agregar</button>
                            </div>

                            <div>
                                <label class="mb-3 block text-[14px] font-bold text-slate-700">Paquete</label>
                                <select class="select-portal" x-model="paqueteIdSeleccionado">
                                    <option value="">Agregar paquete</option>
                                    @foreach ($paquetes as $paquete)
                                        <option value="{{ $paquete->id }}">{{ $paquete->nombre }}</option>
                                    @endforeach
                                </select>
                                <button type="button" @click="agregarPaquete" class="boton-secundario mt-3 w-full text-[14px]">Agregar</button>
                            </div>

                            <div class="flex items-end">
                                <button type="button" @click="mostrarItemManual = !mostrarItemManual" class="boton-secundario w-full text-[14px]"><x-icono nombre="plus" clase="h-4 w-4" /> Item Manual</button>
                            </div>
                        </div>

                        <div x-show="mostrarItemManual" x-transition class="mt-5 rounded-[20px] border border-slate-200 bg-slate-50 p-4 sm:p-5">
                            <div class="grid gap-4 lg:grid-cols-[minmax(0,1fr)_160px_130px_auto]">
                                <input class="input-portal" x-model="manual.descripcion" placeholder="Descripcion del item">
                                <input class="input-portal" x-model="manual.precioUnitario" type="number" min="0" step="0.01" placeholder="Precio">
                                <input class="input-portal" x-model="manual.cantidad" type="number" min="1" step="1" placeholder="Cantidad">
                                <button type="button" @click="agregarManual" class="boton-primario text-[14px]">Agregar</button>
                            </div>
                        </div>

                        <div class="mt-6 space-y-3" x-show="items.length > 0">
                            <template x-for="(item, indice) in items" :key="indice">
                                <div class="flex flex-col gap-3 rounded-[18px] border border-slate-200 px-4 py-4 sm:flex-row sm:items-center sm:justify-between">
                                    <div class="min-w-0">
                                        <div class="text-[12px] font-bold uppercase tracking-[0.22em] text-slate-400" x-text="etiquetaTipo(item.tipoItem)"></div>
                                        <div class="mt-1 text-[18px] font-bold text-slate-950" x-text="item.descripcion"></div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <div class="text-[16px] font-extrabold text-didasa-rojo" x-text="formatoMoneda(item.precioUnitario * item.cantidad)"></div>
                                        <button type="button" @click="eliminarItem(indice)" class="rounded-full border border-slate-200 p-2 text-slate-500 hover:bg-slate-100"><x-icono nombre="x" clase="h-4 w-4" /></button>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div>
                        <label class="mb-3 block text-[15px] font-bold text-slate-900">Notas adicionales</label>
                        <textarea class="textarea-portal min-h-[112px]" name="notas" placeholder="Comentarios o detalles adicionales...">{{ old('notas') }}</textarea>
                    </div>

                    @if ($errors->any())
                        <div class="rounded-[18px] border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-700">{{ $errors->first() }}</div>
                    @endif
                </form>

                <aside class="tarjeta-portal h-fit self-start p-6 sm:p-8 xl:sticky" style="top: calc(var(--altura-navbar) + 22px);">
                    <div class="flex items-center gap-3 text-[28px] font-extrabold tracking-tight text-slate-950"><x-icono nombre="calculator" clase="h-7 w-7" /> Resumen</div>
                    <dl class="mt-8 space-y-4 text-[17px] text-didasa-textoSuave">
                        <div class="flex items-center justify-between gap-4"><dt>Subtotal</dt><dd x-text="formatoMoneda(subtotal)"></dd></div>
                        <div class="flex items-center justify-between gap-4"><dt>ISV(15%)</dt><dd x-text="formatoMoneda(impuesto)"></dd></div>
                    </dl>
                    <div class="mt-6 border-t border-slate-200 pt-5">
                        <div class="flex items-center justify-between gap-4 text-[30px] font-extrabold tracking-tight text-slate-950 sm:text-[38px]"><span>Total</span><span class="text-didasa-rojo" x-text="formatoMoneda(total)"></span></div>
                        <p class="mt-4 text-[15px] text-didasa-textoSuave"><span x-text="items.length"></span> item(s) en la cotizacion</p>
                    </div>
                    <button type="button" @click="document.getElementById('formulario-cotizacion').submit()" class="boton-primario mt-8 w-full text-[15px] disabled:bg-[#e67e8d]" :disabled="!vehiculoId || items.length === 0">
                        <x-icono nombre="plane" clase="h-5 w-5" /> Enviar Cotizacion
                    </button>
                </aside>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        function cotizacionPortal() {
            return {
                vehiculoId: @json(old('vehiculoId', '')),
                servicioIdSeleccionado: '',
                paqueteIdSeleccionado: '',
                mostrarItemManual: false,
                manual: { descripcion: '', precioUnitario: '', cantidad: 1 },
                servicios: @json($serviciosJson),
                paquetes: @json($paquetesJson),
                items: @json($itemsPrevios),
                get subtotal() { return this.items.reduce((total, item) => total + (Number(item.precioUnitario) * Number(item.cantidad)), 0); },
                get impuesto() { return this.subtotal * 0.15; },
                get total() { return this.subtotal + this.impuesto; },
                agregarServicio() {
                    const servicio = this.servicios.find(item => String(item.id) === String(this.servicioIdSeleccionado));
                    if (!servicio) return;
                    this.items.push({ tipoItem: 'servicio', servicioId: servicio.id, descripcion: servicio.descripcion, precioUnitario: servicio.precioUnitario, cantidad: 1 });
                    this.servicioIdSeleccionado = '';
                },
                agregarPaquete() {
                    const paquete = this.paquetes.find(item => String(item.id) === String(this.paqueteIdSeleccionado));
                    if (!paquete) return;
                    this.items.push({ tipoItem: 'paquete', paqueteId: paquete.id, descripcion: paquete.descripcion, precioUnitario: paquete.precioUnitario, cantidad: 1 });
                    this.paqueteIdSeleccionado = '';
                },
                agregarManual() {
                    if (!this.manual.descripcion || !this.manual.precioUnitario) return;
                    this.items.push({ tipoItem: 'manual', descripcion: this.manual.descripcion, precioUnitario: Number(this.manual.precioUnitario), cantidad: Number(this.manual.cantidad || 1) });
                    this.manual = { descripcion: '', precioUnitario: '', cantidad: 1 };
                    this.mostrarItemManual = false;
                },
                eliminarItem(indice) { this.items.splice(indice, 1); },
                etiquetaTipo(tipo) {
                    return tipo === 'manual' ? 'Item Manual' : (tipo === 'paquete' ? 'Paquete' : 'Servicio');
                },
                formatoMoneda(valor) { return `L. ${Number(valor || 0).toFixed(2)}`; },
            };
        }
    </script>
@endpush
