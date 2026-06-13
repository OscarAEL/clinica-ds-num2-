<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Mis Horarios - Clínica D.S.</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-900">

    <main class="mx-auto max-w-6xl px-4 py-8">
        <section class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm font-semibold text-cyan-700">Panel médico</p>
                    <h1 class="mt-1 text-3xl font-bold text-slate-950">Mis horarios</h1>
                    <p class="mt-2 text-slate-600">
                        Gestiona tus horarios de atención disponibles.
                    </p>
                </div>

                <div class="flex flex-col gap-2 sm:flex-row">
                    <a href="{{ Auth::user()->tipo_usuario === 'administrador' ? route('admin.home') : route('medico.home') }}"
                        class="rounded-2xl bg-slate-100 px-5 py-3 text-center font-semibold text-slate-800 hover:bg-slate-200">
                        Volver al panel
                    </a>

                    @if(Auth::user()->tipo_usuario === 'medico')
                    <a href="{{ route('medico.horarios.create') }}"
                        class="rounded-2xl bg-cyan-600 px-5 py-3 text-center font-semibold text-white hover:bg-cyan-700">
                        Nuevo horario
                    </a>
                    @endif
                </div>
            </div>

            @if (session('success'))
            <div class="mt-6 rounded-2xl bg-emerald-50 p-4 text-sm font-semibold text-emerald-700 ring-1 ring-emerald-100">
                {{ session('success') }}
            </div>
            @endif

            <div class="mt-8 overflow-hidden rounded-2xl ring-1 ring-slate-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-100">
                            <tr>
                                <th class="px-4 py-3 text-left text-sm font-bold text-slate-700">Médico</th>
                                <th class="px-4 py-3 text-left text-sm font-bold text-slate-700">Día</th>
                                <th class="px-4 py-3 text-left text-sm font-bold text-slate-700">Hora inicio</th>
                                <th class="px-4 py-3 text-left text-sm font-bold text-slate-700">Hora fin</th>
                                <th class="px-4 py-3 text-left text-sm font-bold text-slate-700">Consultorio</th>
                                <th class="px-4 py-3 text-left text-sm font-bold text-slate-700">Estado</th>
                                <th class="px-4 py-3 text-right text-sm font-bold text-slate-700">Acciones</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-200 bg-white">
                            @forelse ($horarios as $horario)
                            <tr>
                                <td class="px-4 py-4 font-semibold text-slate-950">
                                    {{ $horario->medico->nombres ?? 'General' }} {{ $horario->medico->apellidos ?? '' }}
                                </td>

                                <td class="px-4 py-4 font-semibold text-slate-950">
                                    {{ $horario->dia_semana }}
                                </td>

                                <td class="px-4 py-4 text-sm text-slate-600">
                                    {{ substr($horario->hora_inicio, 0, 5) }}
                                </td>

                                <td class="px-4 py-4 text-sm text-slate-600">
                                    {{ substr($horario->hora_fin, 0, 5) }}
                                </td>

                                <td class="px-4 py-4 text-sm text-slate-600">
                                    {{ $horario->consultorio ?? 'No asignado' }}
                                </td>

                                <td class="px-4 py-4">
                                    @if ($horario->estado === 'disponible')
                                    <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
                                        Disponible
                                    </span>
                                    @else
                                    <span class="rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-700">
                                        No disponible
                                    </span>
                                    @endif
                                </td>

                                <td class="px-4 py-4">
                                    <div class="flex justify-end gap-2">
                                        @if(Auth::user()->tipo_usuario === 'medico')
                                        <a href="{{ route('medico.horarios.edit', $horario->id) }}"
                                            class="rounded-xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-200">
                                            Editar
                                        </a>

                                        @else
                                        <span class="text-xs text-slate-400 italic">Solo lectura</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-4 py-10 text-center text-slate-500">
                                    Todavía no registraste horarios.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6 rounded-2xl bg-cyan-50 p-4 text-sm text-cyan-700 ring-1 ring-cyan-100">
                Sistema conectado a la base de datos persistente SQLite. Los cambios se guardan de forma segura.
            </div>

        </section>
    </main>

</body>

</html>