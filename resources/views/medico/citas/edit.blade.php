<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Horario - Clínica D.S.</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-900">

<main class="mx-auto max-w-3xl px-4 py-8">
    <section class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">

        <h1 class="text-3xl font-bold text-slate-950">Editar horario disponible</h1>

        <form action="{{ route('medico.citas.update', $disponibilidad->id) }}" method="POST" class="mt-6 space-y-4">
            @csrf
            @method('PUT')

            <input type="text" name="especialidad" value="{{ $disponibilidad->especialidad }}" required
                   class="w-full rounded-2xl border border-slate-300 px-4 py-3">

            <select name="dia" class="w-full rounded-2xl border border-slate-300 px-4 py-3">
                @foreach (['Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo'] as $dia)
                    <option value="{{ $dia }}" {{ $disponibilidad->dia === $dia ? 'selected' : '' }}>
                        {{ $dia }}
                    </option>
                @endforeach
            </select>

            <input type="date" name="fecha" value="{{ $disponibilidad->fecha }}" required
                   class="w-full rounded-2xl border border-slate-300 px-4 py-3">

            <input type="time" name="hora_inicio" value="{{ $disponibilidad->hora_inicio }}" required
                   class="w-full rounded-2xl border border-slate-300 px-4 py-3">

            <input type="time" name="hora_fin" value="{{ $disponibilidad->hora_fin }}" required
                   class="w-full rounded-2xl border border-slate-300 px-4 py-3">

            <input type="text" name="lugar" value="{{ $disponibilidad->lugar }}" required
                   class="w-full rounded-2xl border border-slate-300 px-4 py-3">

            <input type="text" name="laboratorio" value="{{ $disponibilidad->laboratorio }}" required
                   class="w-full rounded-2xl border border-slate-300 px-4 py-3">

            <select name="estado" class="w-full rounded-2xl border border-slate-300 px-4 py-3">
                <option value="disponible" {{ $disponibilidad->estado === 'disponible' ? 'selected' : '' }}>Disponible</option>
                <option value="reservado" {{ $disponibilidad->estado === 'reservado' ? 'selected' : '' }}>Reservado</option>
            </select>

            <div class="flex gap-3">
                <button class="rounded-2xl bg-cyan-600 px-6 py-3 font-semibold text-white hover:bg-cyan-700">
                    Actualizar
                </button>

                <a href="{{ route('medico.citas.index') }}"
                   class="rounded-2xl bg-slate-100 px-6 py-3 font-semibold hover:bg-slate-200">
                    Cancelar
                </a>
            </div>
        </form>

    </section>
</main>

</body>
</html>