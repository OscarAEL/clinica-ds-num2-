<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Mi Perfil - Clínica D.S.</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-900">

    <main class="mx-auto max-w-4xl px-4 py-8">
        <section class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">

            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm font-semibold text-cyan-700">Panel médico</p>
                    <h1 class="mt-1 text-3xl font-bold text-slate-950">
                        Mi perfil profesional
                    </h1>
                    <p class="mt-2 text-slate-600">
                        Actualiza tu información visible como médico.
                    </p>
                </div>

                <a href="{{ route('medico.home') }}"
                    class="rounded-2xl bg-slate-100 px-5 py-3 text-center font-semibold text-slate-800 hover:bg-slate-200">
                    Volver
                </a>
            </div>

            @if (session('success'))
            <div class="mb-6 rounded-2xl bg-emerald-50 p-4 text-sm font-semibold text-emerald-700 ring-1 ring-emerald-100">
                {{ session('success') }}
            </div>
            @endif

            @if ($errors->any())
            <div class="mb-6 rounded-2xl bg-red-50 p-4 text-sm text-red-700 ring-1 ring-red-100">
                @foreach ($errors->all() as $error)
                <p>• {{ $error }}</p>
                @endforeach
            </div>
            @endif

            <form action="{{ route('medico.perfil.update') }}" method="POST" class="grid gap-4 md:grid-cols-2">
                @csrf
                @method('PUT')

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Nombres</label>
                    <input type="text" name="nombres" value="{{ old('nombres', $medico->nombres) }}" required
                        class="w-full rounded-2xl border border-slate-300 px-4 py-3 outline-none focus:border-cyan-600 focus:ring-4 focus:ring-cyan-100">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Apellidos</label>
                    <input type="text" name="apellidos" value="{{ old('apellidos', $medico->apellidos) }}"
                        class="w-full rounded-2xl border border-slate-300 px-4 py-3 outline-none focus:border-cyan-600 focus:ring-4 focus:ring-cyan-100">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">DNI</label>
                    <input type="text" name="dni" value="{{ old('dni', $medico->dni) }}"
                        class="w-full rounded-2xl border border-slate-300 px-4 py-3 outline-none focus:border-cyan-600 focus:ring-4 focus:ring-cyan-100">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Teléfono</label>
                    <input type="text" name="telefono" value="{{ old('telefono', $medico->telefono) }}"
                        class="w-full rounded-2xl border border-slate-300 px-4 py-3 outline-none focus:border-cyan-600 focus:ring-4 focus:ring-cyan-100">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">CMP</label>
                    <input type="text" name="cmp" value="{{ old('cmp', $medico->cmp) }}"
                        class="w-full rounded-2xl border border-slate-300 px-4 py-3 outline-none focus:border-cyan-600 focus:ring-4 focus:ring-cyan-100">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Especialidad</label>
                    <input type="text" value="{{ $medico->especialidad->nombre ?? 'No asignada' }}" disabled
                        class="w-full rounded-2xl border border-slate-200 bg-slate-100 px-4 py-3 text-slate-500">
                    <p class="mt-1 text-xs text-slate-500">La especialidad es asignada por el administrador.</p>
                </div>

                <div class="md:col-span-2">
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Correo</label>
                    <input type="email" value="{{ Auth::user()->email }}" disabled
                        class="w-full rounded-2xl border border-slate-200 bg-slate-100 px-4 py-3 text-slate-500">
                    <p class="mt-1 text-xs text-slate-500">El correo se cambia desde la gestión del administrador.</p>
                </div>

                <div class="mt-4 flex flex-col gap-3 sm:flex-row md:col-span-2">
                    <button class="rounded-2xl bg-cyan-600 px-6 py-3 font-semibold text-white hover:bg-cyan-700">
                        Actualizar perfil
                    </button>
                    <a href="{{ route('medico.home') }}" class="rounded-2xl bg-slate-100 px-6 py-3 text-center font-semibold text-slate-800 hover:bg-slate-200">
                        Cancelar
                    </a>
                </div>
            </form>

        </section>
    </main>

</body>

</html>