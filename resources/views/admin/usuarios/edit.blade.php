<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario - Clínica D.S.</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-900">

    <main class="mx-auto max-w-3xl px-4 py-8">
        <section class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">

            <div class="mb-6">
                <p class="text-sm font-semibold text-cyan-700">Panel administrador</p>
                <h1 class="mt-1 text-3xl font-bold text-slate-950">
                    Editar usuario
                </h1>
                <p class="mt-2 text-slate-600">
                    Actualiza la información del usuario seleccionado.
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
                    <label class="mb-1 block text-sm font-semibold text-slate-700">
                        Nombre
                    </label>
                    <input type="text" name="name" value="{{ old('name', $usuario->name) }}" required
                           class="w-full rounded-2xl border border-slate-300 px-4 py-3 outline-none focus:border-cyan-600 focus:ring-4 focus:ring-cyan-100">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">
                        Correo electrónico
                    </label>
                    <input type="email" name="email" value="{{ old('email', $usuario->email) }}" required
                           class="w-full rounded-2xl border border-slate-300 px-4 py-3 outline-none focus:border-cyan-600 focus:ring-4 focus:ring-cyan-100">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">
                        Nueva contraseña
                    </label>
                    <input type="password" name="password"
                           class="w-full rounded-2xl border border-slate-300 px-4 py-3 outline-none focus:border-cyan-600 focus:ring-4 focus:ring-cyan-100"
                           placeholder="Déjalo vacío si no deseas cambiarla">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">
                        Tipo de usuario
                    </label>
                    <select name="tipo_usuario"
                            class="w-full rounded-2xl border border-slate-300 px-4 py-3 outline-none focus:border-cyan-600 focus:ring-4 focus:ring-cyan-100">
                        <option value="administrador" {{ old('tipo_usuario', $usuario->tipo_usuario) === 'administrador' ? 'selected' : '' }}>
                            Administrador
                        </option>

                        <option value="medico" {{ old('tipo_usuario', $usuario->tipo_usuario) === 'medico' ? 'selected' : '' }}>
                            Médico
                        </option>

                        <option value="paciente" {{ old('tipo_usuario', $usuario->tipo_usuario) === 'paciente' ? 'selected' : '' }}>
                            Paciente
                        </option>
                    </select>
                </div>

                <div class="flex flex-col gap-3 pt-4 sm:flex-row">
                    <button class="rounded-2xl bg-cyan-600 px-6 py-3 font-semibold text-white hover:bg-cyan-700">
                        Actualizar usuario
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