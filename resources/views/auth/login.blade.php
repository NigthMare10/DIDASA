@extends('layouts.portal', ['titulo' => 'Ingresar - DIDASA'])

@section('contenido')
    <section class="py-12">
        <div class="contenedor-portal grid gap-8 lg:grid-cols-[minmax(0,1fr)_520px] lg:items-stretch">
            <div class="hero-oscuro hidden p-10 lg:block">
                <div class="max-w-lg pt-16">
                    <div class="inline-flex rounded-full bg-white/10 px-5 py-3 text-sm font-semibold uppercase tracking-[0.3em]">Acceso cliente</div>
                    <h1 class="mt-8 text-6xl font-extrabold leading-tight">Tu vehiculo merece seguimiento total.</h1>
                    <p class="mt-6 text-2xl leading-10 text-slate-300">Ingresa para gestionar tus vehiculos, cotizar servicios, agendar citas y revisar el progreso de tus ordenes.</p>
                </div>
            </div>
            <div class="tarjeta-portal p-8 md:p-10">
                <h1 class="text-5xl font-extrabold text-slate-950">Ingresar</h1>
                <p class="mt-3 text-xl text-didasa-textoSuave">Accede a tu cuenta DIDASA.</p>
                <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-6">
                    @csrf
                    <div>
                        <label class="mb-2 block text-lg font-bold text-slate-900">Correo electronico</label>
                        <input class="input-portal" type="email" name="email" value="{{ old('email') }}" required autofocus>
                    </div>
                    <div>
                        <label class="mb-2 block text-lg font-bold text-slate-900">Contrasena</label>
                        <input class="input-portal" type="password" name="password" required>
                    </div>
                    <label class="flex items-center gap-3 text-base text-didasa-textoSuave"><input type="checkbox" name="remember" class="rounded border-slate-300"> Recordarme</label>
                    @if ($errors->any())
                        <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-700">{{ $errors->first() }}</div>
                    @endif
                    <button class="boton-primario w-full text-xl">Ingresar</button>
                    <div class="text-center text-base text-didasa-textoSuave">No tienes cuenta? <a href="{{ route('register') }}" class="font-bold text-didasa-rojo">Registrate</a></div>
                </form>
            </div>
        </div>
    </section>
@endsection
