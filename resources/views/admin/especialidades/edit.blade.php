<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Especialidad - Clínica D.S.</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-900">

    <main class="mx-auto max-w-3xl px-4 py-8">
        <section class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">

            <div class="mb-6">
                <p class="text-sm font-semibold text-cyan-700">Panel administrador</p>
                <h1 class="mt-1 text-3xl font-bold text-slate-950">
                    Editar especialidad
                </h1>
                <p class="mt-2 text-slate-600">
                    Actualiza la información de la especialidad seleccionada.
                </p>
            </div>

            @if ($errors->any())
                <div class="mb-6 rounded-2xl bg-red-50 p-4 text-sm text-red-700 ring-1 ring-red-100">
                    @foreach ($errors->all() as $error)
                        <p>• {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('admin.especialidades.update', $especialidad->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">
                        Nombre de la especialidad
                    </label>
                    <input type="text" name="nombre" value="{{ old('nombre', $especialidad->nombre) }}" required
                           class="w-full rounded-2xl border border-slate-300 px-4 py-3 outline-none focus:border-cyan-600 focus:ring-4 focus:ring-cyan-100">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">
                        Descripción
                    </label>
                    <textarea name="descripcion" rows="4"
                              class="w-full rounded-2xl border border-slate-300 px-4 py-3 outline-none focus:border-cyan-600 focus:ring-4 focus:ring-cyan-100">{{ old('descripcion', $especialidad->descripcion) }}</textarea>
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">
                        Estado
                    </label>
                    <select name="estado"
                            class="w-full rounded-2xl border border-slate-300 px-4 py-3 outline-none focus:border-cyan-600 focus:ring-4 focus:ring-cyan-100">
                        <option value="activo" {{ old('estado', $especialidad->estado) === 'activo' ? 'selected' : '' }}>
                            Activo
                        </option>
                        <option value="inactivo" {{ old('estado', $especialidad->estado) === 'inactivo' ? 'selected' : '' }}>
                            Inactivo
                        </option>
                    </select>
                </div>

                <div class="flex flex-col gap-3 pt-4 sm:flex-row">
                    <button class="rounded-2xl bg-cyan-600 px-6 py-3 font-semibold text-white hover:bg-cyan-700">
                        Actualizar especialidad
                    </button>

                    <a href="{{ route('admin.especialidades.index') }}"
                       class="rounded-2xl bg-slate-100 px-6 py-3 text-center font-semibold text-slate-800 hover:bg-slate-200">
                        Cancelar
                    </a>
                </div>
            </form>

            <div class="mt-6 rounded-2xl bg-cyan-50 p-4 text-sm text-cyan-700 ring-1 ring-cyan-100">
                Esta pantalla funciona como prueba visual. Los cambios se guardan temporalmente en la sesión.
            </div>

        </section>
    </main>

</body>
</html>