@extends('layouts.portal', ['titulo' => 'Registro - DIDASA'])

@section('contenido')
    <section class="py-12">
        <div class="contenedor-portal grid gap-8 lg:grid-cols-[minmax(0,1fr)_560px] lg:items-stretch">
            <div class="hero-oscuro hidden p-10 lg:block">
                <div class="max-w-lg pt-16">
                    <div class="inline-flex rounded-full bg-white/10 px-5 py-3 text-sm font-semibold uppercase tracking-[0.3em]">Nuevo cliente</div>
                    <h1 class="mt-8 text-6xl font-extrabold leading-tight">Crea tu portal y empieza hoy.</h1>
                    <p class="mt-6 text-2xl leading-10 text-slate-300">Obten acceso a cotizaciones instantaneas, seguimiento de ordenes y beneficios de fidelidad.</p>
                </div>
            </div>
            <div class="tarjeta-portal p-8 md:p-10">
                <h1 class="text-5xl font-extrabold text-slate-950">Crear cuenta</h1>
                <p class="mt-3 text-xl text-didasa-textoSuave">Registra tus datos para acceder al portal.</p>
                <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-6">
                    @csrf
                    <div>
                        <label class="mb-2 block text-lg font-bold text-slate-900">Nombre completo</label>
                        <input class="input-portal" type="text" name="name" value="{{ old('name') }}" required autofocus>
                    </div>
                    <div>
                        <label class="mb-2 block text-lg font-bold text-slate-900">Correo electronico</label>
                        <input class="input-portal" type="email" name="email" value="{{ old('email') }}" required>
                    </div>
                    <div>
                        <label class="mb-2 block text-lg font-bold text-slate-900">Contrasena</label>
                        <input class="input-portal" type="password" name="password" required>
                    </div>
                    <div>
                        <label class="mb-2 block text-lg font-bold text-slate-900">Confirmar contrasena</label>
                        <input class="input-portal" type="password" name="password_confirmation" required>
                    </div>
                    @if ($errors->any())
                        <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-700">{{ $errors->first() }}</div>
                    @endif
                    <button class="boton-primario w-full text-xl">Crear cuenta</button>
                    <div class="text-center text-base text-didasa-textoSuave">Ya tienes cuenta? <a href="{{ route('login') }}" class="font-bold text-didasa-rojo">Ingresa</a></div>
                </form>
            </div>
        </div>
    </section>
@endsection
