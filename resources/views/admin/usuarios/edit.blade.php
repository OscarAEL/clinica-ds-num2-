<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Perfil de Usuario - Clínica D.S.</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-900">

    <main class="mx-auto max-w-3xl px-4 py-8">
        <section class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">

            <div class="mb-6">
                <p class="text-sm font-semibold text-cyan-700">Panel administrador</p>
                <h1 class="mt-1 text-3xl font-bold text-slate-950">
                    Modificar rol de usuario
                </h1>
                <p class="mt-2 text-slate-600">
                    Cambia los privilegios o el perfil asignado al usuario actual.
                </p>
            </div>

            @if ($errors->any())
            <div class="mb-6 rounded-2xl bg-red-50 p-4 text-sm text-red-700 ring-1 ring-red-100">
                @foreach ($errors->all() as $error)
                <p>• {{ $error }}</p>
                @endforeach
            </div>
            @endif

            <form action="{{ route('admin.usuarios.update', $usuario->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Nombre completo</label>
                    <input type="text" value="{{ $usuario->name }}" disabled
                        class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-500 outline-none cursor-not-allowed">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Correo electrónico</label>
                    <input type="email" value="{{ $usuario->email }}" disabled
                        class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-500 outline-none cursor-not-allowed">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Tipo de Usuario (Perfil)</label>
                    <select name="tipo_usuario" required
                        class="w-full rounded-2xl border border-slate-300 px-4 py-3 outline-none focus:border-cyan-600 focus:ring-4 focus:ring-cyan-100">
                        <option value="paciente" {{ old('tipo_usuario', $usuario->tipo_usuario) === 'paciente' ? 'selected' : '' }}>Paciente</option>
                        <option value="medico" {{ old('tipo_usuario', $usuario->tipo_usuario) === 'medico' ? 'selected' : '' }}>Médico</option>
                        <option value="administrador" {{ old('tipo_usuario', $usuario->tipo_usuario) === 'administrador' ? 'selected' : '' }}>Administrador</option>
                    </select>
                    @error('tipo_usuario')
                    <span class="mt-1 block text-sm font-semibold text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex flex-col gap-3 pt-4 sm:flex-row">
                    <button class="rounded-2xl bg-cyan-600 px-6 py-3 font-semibold text-white hover:bg-cyan-700">
                        Actualizar Perfil
                    </button>

                    <a href="{{ route('admin.usuarios.index') }}"
                        class="rounded-2xl bg-slate-100 px-6 py-3 text-center font-semibold text-slate-800 hover:bg-slate-200">
                        Cancelar
                    </a>
                </div>
            </form>

        </section>
    </main>

</body>

</html>