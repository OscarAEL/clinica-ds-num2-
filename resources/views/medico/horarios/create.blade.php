<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Nuevo Horario - Clínica D.S.</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-900">

    <main class="mx-auto max-w-3xl px-4 py-8">
        <section class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">

            <div class="mb-6">
                <p class="text-sm font-semibold text-cyan-700">Panel médico</p>
                <h1 class="mt-1 text-3xl font-bold text-slate-950">
                    Registrar horario
                </h1>
                <p class="mt-2 text-slate-600">
                    Agrega un nuevo horario de atención.
                </p>
            </div>

            @if ($errors->any())
            <div class="mb-6 rounded-2xl bg-red-50 p-4 text-sm text-red-700 ring-1 ring-red-100">
                @foreach ($errors->all() as $error)
                <p>• {{ $error }}</p>
                @endforeach
            </div>
            @endif

            <form action="{{ route('medico.horarios.store') }}" method="POST" class="grid gap-4 md:grid-cols-2">
                @csrf

                <div class="md:col-span-2">
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Día de atención</label>
                    <select name="dia_semana"
                        class="w-full rounded-2xl border border-slate-300 px-4 py-3 outline-none focus:border-cyan-600 focus:ring-4 focus:ring-cyan-100">
                        @foreach (['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'] as $dia)
                        <option value="{{ $dia }}" {{ old('dia_semana') == $dia ? 'selected' : '' }}>{{ $dia }}</option>
                        @endforeach
                    </select>
                    @error('dia_semana') <span class="mt-1 block text-sm font-semibold text-red-600">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Hora inicio</label>
                    <input type="time" name="hora_inicio" value="{{ old('hora_inicio') }}" required
                        class="w-full rounded-2xl border border-slate-300 px-4 py-3 outline-none focus:border-cyan-600 focus:ring-4 focus:ring-cyan-100">
                    @error('hora_inicio') <span class="mt-1 block text-sm font-semibold text-red-600">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Hora fin</label>
                    <input type="time" name="hora_fin" value="{{ old('hora_fin') }}" required
                        class="w-full rounded-2xl border border-slate-300 px-4 py-3 outline-none focus:border-cyan-600 focus:ring-4 focus:ring-cyan-100">
                    @error('hora_fin') <span class="mt-1 block text-sm font-semibold text-red-600">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Consultorio</label>
                    <input type="text" name="consultorio" value="{{ old('consultorio') }}"
                        class="w-full rounded-2xl border border-slate-300 px-4 py-3 outline-none focus:border-cyan-600 focus:ring-4 focus:ring-cyan-100"
                        placeholder="Ejemplo: Consultorio 201">
                    @error('consultorio') <span class="mt-1 block text-sm font-semibold text-red-600">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Estado</label>
                    <select name="estado"
                        class="w-full rounded-2xl border border-slate-300 px-4 py-3 outline-none focus:border-cyan-600 focus:ring-4 focus:ring-cyan-100">
                        <option value="disponible" {{ old('estado') == 'disponible' ? 'selected' : '' }}>Disponible</option>
                        <option value="no_disponible" {{ old('estado') == 'no_disponible' ? 'selected' : '' }}>No disponible</option>
                    </select>
                    @error('estado') <span class="mt-1 block text-sm font-semibold text-red-600">{{ $message }}</span> @enderror
                </div>

                <div class="mt-4 flex flex-col gap-3 sm:flex-row md:col-span-2">
                    <button class="rounded-2xl bg-cyan-600 px-6 py-3 font-semibold text-white hover:bg-cyan-700">
                        Guardar horario
                    </button>
                    <a href="{{ route('medico.horarios.index') }}"
                        class="rounded-2xl bg-slate-100 px-6 py-3 text-center font-semibold text-slate-800 hover:bg-slate-200">
                        Cancelar
                    </a>
                </div>
            </form>

        </section>
    </main>

</body>

</html>