@extends('layouts.portal', ['titulo' => 'Perfil - DIDASA'])

@section('contenido')
    <section class="py-12">
        <div class="contenedor-portal grid gap-8 lg:grid-cols-2">
            <div class="tarjeta-portal p-8">
                <h1 class="text-4xl font-extrabold text-slate-950">Perfil</h1>
                <p class="mt-3 text-xl text-didasa-textoSuave">Actualiza tu informacion basica de acceso.</p>

                <form method="POST" action="{{ route('profile.update') }}" class="mt-8 space-y-6">
                    @csrf
                    @method('PATCH')
                    <div>
                        <label class="mb-2 block text-lg font-bold text-slate-900">Nombre</label>
                        <input class="input-portal" name="name" value="{{ old('name', $user->name) }}">
                    </div>
                    <div>
                        <label class="mb-2 block text-lg font-bold text-slate-900">Correo</label>
                        <input class="input-portal" name="email" type="email" value="{{ old('email', $user->email) }}">
                    </div>
                    @if ($errors->updateProfileInformation->any())
                        <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-700">{{ $errors->updateProfileInformation->first() }}</div>
                    @endif
                    <button class="boton-primario">Guardar cambios</button>
                </form>
            </div>

            <div class="space-y-8">
                <div class="tarjeta-portal p-8">
                    <h2 class="text-3xl font-extrabold text-slate-950">Cambiar contrasena</h2>
                    <form method="POST" action="{{ route('password.update') }}" class="mt-6 space-y-5">
                        @csrf
                        @method('PUT')
                        <input class="input-portal" name="current_password" type="password" placeholder="Contrasena actual">
                        <input class="input-portal" name="password" type="password" placeholder="Nueva contrasena">
                        <input class="input-portal" name="password_confirmation" type="password" placeholder="Confirmar nueva contrasena">
                        @if ($errors->updatePassword->any())
                            <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-700">{{ $errors->updatePassword->first() }}</div>
                        @endif
                        <button class="boton-secundario">Actualizar contrasena</button>
                    </form>
                </div>

                <div class="tarjeta-portal p-8">
                    <h2 class="text-3xl font-extrabold text-slate-950">Eliminar cuenta</h2>
                    <p class="mt-3 text-lg text-didasa-textoSuave">Esta accion no se puede deshacer.</p>
                    <form method="POST" action="{{ route('profile.destroy') }}" class="mt-6 space-y-4">
                        @csrf
                        @method('DELETE')
                        <input class="input-portal" name="password" type="password" placeholder="Confirma tu contrasena">
                        @if ($errors->userDeletion->any())
                            <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-700">{{ $errors->userDeletion->first() }}</div>
                        @endif
                        <button class="boton-primario bg-slate-900 hover:bg-slate-800">Eliminar cuenta</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
