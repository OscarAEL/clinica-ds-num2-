<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Citas - Clínica D.S.</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-900">

<main class="mx-auto max-w-7xl px-4 py-8">
    <section class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-semibold text-cyan-700">Panel médico</p>
                <h1 class="mt-1 text-3xl font-bold text-slate-950">Mis citas</h1>
                <p class="mt-2 text-slate-600">
                    Registra tus horarios disponibles y revisa las citas reservadas por pacientes.
                </p>
            </div>

            <a href="{{ route('medico.home') }}"
               class="rounded-2xl bg-slate-100 px-5 py-3 text-center font-semibold text-slate-800 hover:bg-slate-200">
                Volver
            </a>
        </div>

        @if (session('success'))
            <div class="mt-6 rounded-2xl bg-emerald-50 p-4 text-sm font-semibold text-emerald-700 ring-1 ring-emerald-100">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mt-6 rounded-2xl bg-red-50 p-4 text-sm font-semibold text-red-700 ring-1 ring-red-100">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('medico.citas.store') }}" method="POST" class="mt-8 grid gap-4 rounded-3xl bg-slate-50 p-5 ring-1 ring-slate-200 md:grid-cols-3">
            @csrf

            <div>
                <label class="mb-1 block text-sm font-semibold">Especialidad</label>
                <input type="text" name="especialidad" required placeholder="Medicina General"
                       class="w-full rounded-2xl border border-slate-300 px-4 py-3">
            </div>

            <div>
                <label class="mb-1 block text-sm font-semibold">Día</label>
                <select name="dia" class="w-full rounded-2xl border border-slate-300 px-4 py-3">
                    <option>Lunes</option>
                    <option>Martes</option>
                    <option>Miércoles</option>
                    <option>Jueves</option>
                    <option>Viernes</option>
                    <option>Sábado</option>
                    <option>Domingo</option>
                </select>
            </div>

            <div>
                <label class="mb-1 block text-sm font-semibold">Fecha</label>
                <input type="date" name="fecha" required
                       class="w-full rounded-2xl border border-slate-300 px-4 py-3">
            </div>

            <div>
                <label class="mb-1 block text-sm font-semibold">Hora inicio</label>
                <input type="time" name="hora_inicio" required
                       class="w-full rounded-2xl border border-slate-300 px-4 py-3">
            </div>

            <div>
                <label class="mb-1 block text-sm font-semibold">Hora fin</label>
                <input type="time" name="hora_fin" required
                       class="w-full rounded-2xl border border-slate-300 px-4 py-3">
            </div>

            <div>
                <label class="mb-1 block text-sm font-semibold">Lugar</label>
                <input type="text" name="lugar" required placeholder="Segundo piso"
                       class="w-full rounded-2xl border border-slate-300 px-4 py-3">
            </div>

            <div class="md:col-span-2">
                <label class="mb-1 block text-sm font-semibold">Laboratorio</label>
                <input type="text" name="laboratorio" required placeholder="Laboratorio A"
                       class="w-full rounded-2xl border border-slate-300 px-4 py-3">
            </div>

            <div class="flex items-end">
                <button class="w-full rounded-2xl bg-cyan-600 px-6 py-3 font-semibold text-white hover:bg-cyan-700">
                    Agregar horario
                </button>
            </div>
        </form>

        <div class="mt-8 overflow-hidden rounded-2xl ring-1 ring-slate-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-100">
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-bold">Fecha</th>
                            <th class="px-4 py-3 text-left text-sm font-bold">Horario</th>
                            <th class="px-4 py-3 text-left text-sm font-bold">Lugar</th>
                            <th class="px-4 py-3 text-left text-sm font-bold">Laboratorio</th>
                            <th class="px-4 py-3 text-left text-sm font-bold">Estado</th>
                            <th class="px-4 py-3 text-left text-sm font-bold">Paciente</th>
                            <th class="px-4 py-3 text-right text-sm font-bold">Acciones</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-200 bg-white">
                        @forelse ($disponibilidades as $item)
                            <tr>
                                <td class="px-4 py-4">
                                    <p class="font-semibold">{{ $item->dia }}</p>
                                    <p class="text-sm text-slate-600">{{ $item->fecha }}</p>
                                </td>

                                <td class="px-4 py-4 text-sm">
                                    {{ $item->hora_inicio }} - {{ $item->hora_fin }}
                                </td>

                                <td class="px-4 py-4 text-sm">{{ $item->lugar }}</td>

                                <td class="px-4 py-4 text-sm">{{ $item->laboratorio }}</td>

                                <td class="px-4 py-4">
                                    @if ($item->estado === 'disponible')
                                        <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
                                            Disponible
                                        </span>
                                    @else
                                        <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700">
                                            Reservado
                                        </span>
                                    @endif
                                </td>

                                <td class="px-4 py-4 text-sm">
                                    {{ $item->paciente ?? 'Sin paciente' }}
                                </td>

                                <td class="px-4 py-4">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('medico.citas.edit', $item->id) }}"
                                           class="rounded-xl bg-slate-100 px-4 py-2 text-sm font-semibold hover:bg-slate-200">
                                            Editar
                                        </a>

                                        <form action="{{ route('medico.citas.destroy', $item->id) }}" method="POST"
                                              onsubmit="return confirm('¿Eliminar este horario?')">
                                            @csrf
                                            @method('DELETE')

                                            <button class="rounded-xl bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-10 text-center text-slate-500">
                                    Todavía no registraste horarios disponibles.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</main>

</body>
</html>