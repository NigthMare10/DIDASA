@php($contactoFooter = config('didasa.contacto'))

<footer class="mt-16 bg-[#1b2538] py-14 text-white">
    <div class="contenedor-portal grid gap-10 border-b border-white/10 pb-10 md:grid-cols-2 xl:grid-cols-4">
        <div>
            <div class="flex items-center gap-4">
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white/8 text-white">
                    <x-icono nombre="llave" clase="h-5 w-5" />
                </div>
                <div>
                    <div class="text-[30px] font-extrabold leading-none">DIDASA</div>
                    <div class="mt-1 text-[11px] uppercase tracking-[0.28em] text-slate-400">Tecnicentro</div>
                </div>
            </div>
            <p class="mt-5 max-w-sm text-[16px] leading-8 text-slate-300">Tecnicentro de confianza con servicio profesional y transparente para tu vehiculo.</p>
        </div>

        <div>
            <h3 class="text-[14px] font-extrabold tracking-[0.24em] text-white">SERVICIOS</h3>
            <ul class="mt-5 space-y-3 text-[16px] text-slate-300">
                <li><a href="{{ route('servicios.index') }}" class="transition hover:text-white">Catalogo de Servicios</a></li>
                <li><a href="{{ route('cotizaciones.index') }}" class="transition hover:text-white">Cotizar en Linea</a></li>
                <li><a href="{{ route('citas.index') }}" class="transition hover:text-white">Agendar Cita</a></li>
            </ul>
        </div>

        <div>
            <h3 class="text-[14px] font-extrabold tracking-[0.24em] text-white">MI CUENTA</h3>
            <ul class="mt-5 space-y-3 text-[16px] text-slate-300">
                <li><a href="{{ route('vehiculos.index') }}" class="transition hover:text-white">Mis Vehiculos</a></li>
                <li><a href="{{ route('cotizaciones.index') }}" class="transition hover:text-white">Mis Cotizaciones</a></li>
                <li><a href="{{ route('fidelidad.index') }}" class="transition hover:text-white">Programa de Fidelidad</a></li>
            </ul>
        </div>

        <div>
            <h3 class="text-[14px] font-extrabold tracking-[0.24em] text-white">CONTACTO</h3>
            <ul class="mt-5 space-y-4 text-[16px] text-slate-300">
                <li class="flex items-center gap-3"><x-icono nombre="telefono" clase="h-4 w-4" /> {{ $contactoFooter['telefono'] }}</li>
                <li class="flex items-center gap-3"><x-icono nombre="ubicacion" clase="h-4 w-4" /> {{ $contactoFooter['direccion'] }}</li>
                <li class="flex items-center gap-3"><x-icono nombre="reloj" clase="h-4 w-4" /> {{ $contactoFooter['horario'] }}</li>
            </ul>
        </div>
    </div>
    <div class="contenedor-portal pt-6 text-center text-[15px] text-slate-400">&copy; 2026 Tecnicentro DIDASA - Grupo CAP Honduras. Todos los derechos reservados.</div>
</footer>
