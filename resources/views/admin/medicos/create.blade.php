<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Médico - Clínica D.S.</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-900">

    <main class="mx-auto max-w-4xl px-4 py-8">

        <section class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">

            <div class="mb-6">
                <p class="text-sm font-semibold text-cyan-700">Panel administrador</p>
                <h1 class="mt-1 text-3xl font-bold text-slate-950">
                    Registrar médico
                </h1>
                <p class="mt-2 text-slate-600">
                    Completa los datos del médico. También se creará su usuario para iniciar sesión.
                </p>
            </div>

            @if ($errors->any())
                <div class="mb-6 rounded-2xl bg-red-50 p-4 text-sm text-red-700 ring-1 ring-red-100">
                    @foreach ($errors->all() as $error)
                        <p>• {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('admin.medicos.store') }}" method="POST" class="grid gap-4 md:grid-cols-2">
                @csrf

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Nombres</label>
                    <input type="text" name="nombres" value="{{ old('nombres') }}" required
                           class="w-full rounded-2xl border border-slate-300 px-4 py-3 outline-none focus:border-cyan-600 focus:ring-4 focus:ring-cyan-100">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Apellidos</label>
                    <input type="text" name="apellidos" value="{{ old('apellidos') }}" required
                           class="w-full rounded-2xl border border-slate-300 px-4 py-3 outline-none focus:border-cyan-600 focus:ring-4 focus:ring-cyan-100">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Correo</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="w-full rounded-2xl border border-slate-300 px-4 py-3 outline-none focus:border-cyan-600 focus:ring-4 focus:ring-cyan-100"
                           placeholder="medico@clinicads.com">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Contraseña</label>
                    <input type="password" name="password" required
                           class="w-full rounded-2xl border border-slate-300 px-4 py-3 outline-none focus:border-cyan-600 focus:ring-4 focus:ring-cyan-100"
                           placeholder="Mínimo 6 caracteres">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">DNI</label>
                    <input type="text" name="dni" value="{{ old('dni') }}"
                           class="w-full rounded-2xl border border-slate-300 px-4 py-3 outline-none focus:border-cyan-600 focus:ring-4 focus:ring-cyan-100">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Teléfono</label>
                    <input type="text" name="telefono" value="{{ old('telefono') }}"
                           class="w-full rounded-2xl border border-slate-300 px-4 py-3 outline-none focus:border-cyan-600 focus:ring-4 focus:ring-cyan-100">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Especialidad</label>
                    <input type="text" name="especialidad" value="{{ old('especialidad') }}" required
                           class="w-full rounded-2xl border border-slate-300 px-4 py-3 outline-none focus:border-cyan-600 focus:ring-4 focus:ring-cyan-100"
                           placeholder="Ejemplo: Medicina General">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">CMP</label>
                    <input type="text" name="cmp" value="{{ old('cmp') }}"
                           class="w-full rounded-2xl border border-slate-300 px-4 py-3 outline-none focus:border-cyan-600 focus:ring-4 focus:ring-cyan-100"
                           placeholder="Código médico">
                </div>

                <div class="md:col-span-2">
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Estado</label>
                    <select name="estado"
                            class="w-full rounded-2xl border border-slate-300 px-4 py-3 outline-none focus:border-cyan-600 focus:ring-4 focus:ring-cyan-100">
                        <option value="activo" {{ old('estado') === 'activo' ? 'selected' : '' }}>Activo</option>
                        <option value="inactivo" {{ old('estado') === 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>

                <div class="mt-4 flex flex-col gap-3 sm:flex-row md:col-span-2">
                    <button class="rounded-2xl bg-cyan-600 px-6 py-3 font-semibold text-white hover:bg-cyan-700">
                        Guardar médico
                    </button>

                    <a href="{{ route('admin.medicos.index') }}"
                       class="rounded-2xl bg-slate-100 px-6 py-3 text-center font-semibold text-slate-800 hover:bg-slate-200">
                        Cancelar
                    </a>
                </div>
            </form>

        </section>

    </main>

</body>
</html>