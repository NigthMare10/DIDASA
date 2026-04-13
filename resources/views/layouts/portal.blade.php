<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $titulo ?? 'DIDASA Tecnicentro' }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="overflow-x-hidden">
        @php($enlaces = [
            ['ruta' => 'vehiculos.index', 'texto' => 'Mis Vehiculos', 'icono' => 'vehiculo', 'activa' => request()->routeIs('vehiculos.index') || request()->routeIs('vehiculos.carnet')],
            ['ruta' => 'servicios.index', 'texto' => 'Servicios', 'icono' => 'llave', 'activa' => request()->routeIs('servicios.index')],
            ['ruta' => 'cotizaciones.index', 'texto' => 'Cotizar', 'icono' => 'documento', 'activa' => request()->routeIs('cotizaciones.index')],
            ['ruta' => 'citas.index', 'texto' => 'Agendar', 'icono' => 'calendario', 'activa' => request()->routeIs('citas.index') || request()->routeIs('citas.disponibilidad')],
            ['ruta' => 'ordenes.index', 'texto' => 'Mis Ordenes', 'icono' => 'portapapeles', 'activa' => request()->routeIs('ordenes.index')],
            ['ruta' => 'fidelidad.index', 'texto' => 'Fidelidad', 'icono' => 'trofeo', 'activa' => request()->routeIs('fidelidad.index')],
        ])

        <div x-data="{ menuMovilAbierto: false, menuCuentaAbierto: false, encabezadoElevado: false }" @scroll.window="encabezadoElevado = window.scrollY > 6" class="flex min-h-screen flex-col overflow-x-clip">
            <header :class="encabezadoElevado ? 'bg-[rgba(245,247,251,0.82)] shadow-[0_14px_34px_rgba(17,24,39,0.12)] border-b border-white/70' : 'bg-[rgba(247,249,252,0.72)] border-b border-white/50'" class="fixed inset-x-0 top-0 z-50 backdrop-blur-[14px] transition duration-200">
                <div class="contenedor-portal flex h-[96px] items-center justify-between gap-4 lg:gap-5">
                    <a href="{{ route('inicio') }}" class="flex min-w-0 items-center gap-3 sm:gap-4">
                        <div class="flex h-[52px] w-[52px] shrink-0 items-center justify-center rounded-[19px] bg-didasa-rojo text-white sm:h-[54px] sm:w-[54px]">
                            <x-icono nombre="llave" clase="h-6 w-6 sm:h-[27px] sm:w-[27px]" />
                        </div>
                        <div class="min-w-0">
                            <div class="text-[27px] font-extrabold leading-none tracking-tight text-slate-950 sm:text-[31px]">DIDASA</div>
                            <div class="mt-1 text-[11px] uppercase tracking-[0.26em] text-slate-500 sm:text-[11px]">Tecnicentro</div>
                        </div>
                    </a>

                    <nav class="hidden min-w-0 flex-1 items-center justify-center gap-0.5 lg:flex xl:gap-1">
                        @foreach ($enlaces as $enlace)
                            @auth
                                <a href="{{ route($enlace['ruta']) }}" @class(['navegacion-item', 'navegacion-item-activo' => $enlace['activa']])>
                                    <x-icono :nombre="$enlace['icono']" clase="h-[18px] w-[18px]" />
                                    <span>{{ $enlace['texto'] }}</span>
                                </a>
                            @endauth
                        @endforeach
                    </nav>

                    <div class="hidden shrink-0 items-center gap-2.5 lg:flex">
                        @auth
                            <button type="button" class="rounded-full p-2 text-slate-700 transition hover:bg-white/60">
                                <x-icono nombre="campana" clase="h-[18px] w-[18px]" />
                            </button>

                            <div class="relative">
                                <button type="button" @click="menuCuentaAbierto = !menuCuentaAbierto" class="flex max-w-[292px] items-center gap-3 rounded-full border border-slate-200/90 bg-white/88 pl-3 pr-4 py-2 shadow-sm transition hover:border-slate-300 hover:bg-white hover:shadow-md">
                                    <span class="flex h-[44px] w-[44px] shrink-0 items-center justify-center rounded-full bg-didasa-rojo text-[16px] font-bold text-white">{{ auth()->user()->obtenerIniciales() }}</span>
                                    <span class="min-w-0 text-left">
                                        <span class="block truncate text-[14px] font-semibold capitalize leading-5 text-slate-900">{{ Str::lower(auth()->user()->name) }}</span>
                                    </span>
                                    <x-icono nombre="chevron-down" clase="h-4 w-4 shrink-0 text-slate-500" />
                                </button>

                                <div x-show="menuCuentaAbierto" @click.outside="menuCuentaAbierto = false" x-transition class="absolute right-0 mt-3 w-[320px] overflow-hidden rounded-[22px] border border-slate-200 bg-white shadow-[0_18px_42px_rgba(17,24,39,0.18)]">
                                    <div class="border-b border-slate-100 px-6 py-5">
                                        <div class="text-[18px] font-bold capitalize text-slate-950">{{ Str::lower(auth()->user()->name) }}</div>
                                        <div class="mt-1 truncate text-[14px] text-didasa-textoSuave">{{ auth()->user()->email }}</div>
                                    </div>
                                    <div class="px-3 py-3">
                                        <a href="{{ route('vehiculos.index') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 text-[15px] font-medium text-slate-800 transition hover:bg-slate-100"><x-icono nombre="vehiculo" clase="h-5 w-5 text-slate-500" /> Mis Vehiculos</a>
                                        <a href="{{ route('cotizaciones.historial') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 text-[15px] font-medium text-slate-800 transition hover:bg-slate-100"><x-icono nombre="documento" clase="h-5 w-5 text-slate-500" /> Mis Cotizaciones</a>
                                        <a href="{{ route('citas.historial') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 text-[15px] font-medium text-slate-800 transition hover:bg-slate-100"><x-icono nombre="calendario" clase="h-5 w-5 text-slate-500" /> Mis Citas</a>
                                        <a href="{{ route('fidelidad.index') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 text-[15px] font-medium text-slate-800 transition hover:bg-slate-100"><x-icono nombre="trofeo" clase="h-5 w-5 text-slate-500" /> Programa de Fidelidad</a>
                                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 text-[15px] font-medium text-slate-800 transition hover:bg-slate-100"><x-icono nombre="documento" clase="h-5 w-5 text-slate-500" /> Perfil</a>
                                    </div>
                                    <div class="border-t border-slate-100 p-3">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                            <button type="submit" class="flex w-full items-center gap-3 rounded-2xl px-4 py-3 text-left text-[15px] font-semibold text-red-600 transition hover:bg-red-50"> <x-icono nombre="flecha-derecha" clase="h-4 w-4 rotate-180" /> Cerrar Sesion</button>
                                    </form>
                                    </div>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="boton-secundario">Ingresar</a>
                            <a href="{{ route('register') }}" class="boton-primario">Crear cuenta</a>
                        @endauth
                    </div>

                    <button type="button" @click="menuMovilAbierto = !menuMovilAbierto" class="rounded-2xl border border-slate-200 p-3 lg:hidden">
                        <span class="block h-0.5 w-5 bg-slate-900"></span>
                        <span class="mt-1 block h-0.5 w-5 bg-slate-900"></span>
                        <span class="mt-1 block h-0.5 w-5 bg-slate-900"></span>
                    </button>
                </div>

                <div x-show="menuMovilAbierto" x-transition class="border-t border-slate-200 bg-white lg:hidden">
                    <div class="contenedor-portal flex flex-col gap-2 py-4">
                        @auth
                            <div class="mb-2 flex items-center gap-3 rounded-[22px] border border-slate-200 px-4 py-3">
                                <span class="flex h-11 w-11 items-center justify-center rounded-full bg-didasa-rojo text-base font-bold text-white">{{ auth()->user()->obtenerIniciales() }}</span>
                                <div class="min-w-0">
                                    <div class="truncate text-[15px] font-semibold capitalize text-slate-900">{{ Str::lower(auth()->user()->name) }}</div>
                                    <div class="truncate text-[13px] text-didasa-textoSuave">{{ auth()->user()->email }}</div>
                                </div>
                            </div>
                            @foreach ($enlaces as $enlace)
                                <a href="{{ route($enlace['ruta']) }}" class="navegacion-item {{ $enlace['activa'] ? 'navegacion-item-activo' : '' }}">
                                    <x-icono :nombre="$enlace['icono']" clase="h-5 w-5" />
                                    <span>{{ $enlace['texto'] }}</span>
                                </a>
                            @endforeach
                            <a href="{{ route('cotizaciones.historial') }}" class="navegacion-item"><x-icono nombre="documento" clase="h-5 w-5" /> Mis Cotizaciones</a>
                            <a href="{{ route('citas.historial') }}" class="navegacion-item"><x-icono nombre="calendario" clase="h-5 w-5" /> Mis Citas</a>
                            <a href="{{ route('profile.edit') }}" class="navegacion-item"><x-icono nombre="documento" clase="h-5 w-5" /> Perfil</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="boton-secundario w-full">Cerrar sesion</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="boton-secundario w-full">Ingresar</a>
                            <a href="{{ route('register') }}" class="boton-primario w-full">Crear cuenta</a>
                        @endauth
                    </div>
                </div>
            </header>

            @if (session('estado'))
                <div class="pointer-events-none fixed right-4 top-[104px] z-50 w-[min(92vw,420px)]">
                    <div class="rounded-[20px] border border-emerald-500/20 bg-[#00311a] px-5 py-4 text-[15px] font-semibold text-emerald-300 shadow-2xl">
                        @include('partials.mensajes-flash', ['estado' => session('estado')])
                    </div>
                </div>
            @endif

            <main class="flex-1 overflow-x-clip" style="padding-top: var(--altura-navbar);">
                @yield('contenido')
            </main>

            @hasSection('footer')
                @yield('footer')
            @else
                @include('partials.footer-portal')
            @endif
        </div>

        @stack('scripts')
    </body>
</html>
