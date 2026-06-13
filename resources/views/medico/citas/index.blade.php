<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Mis Citas - Clínica D.S.</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-900">

    <main class="mx-auto max-w-5xl px-4 py-8">
        <section class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm font-semibold text-cyan-700">Panel médico</p>
                    <h1 class="mt-1 text-3xl font-bold text-slate-950">Citas programadas</h1>
                    <p class="mt-2 text-slate-600">
                        Aquí puedes revisar los turnos que ya han sido reservados por los pacientes.
                    </p>
                </div>

                <a href="{{ route('medico.home') }}"
                    class="rounded-2xl bg-slate-100 px-5 py-3 text-center font-semibold text-slate-800 hover:bg-slate-200">
                    Volver
                </a>
            </div>

            <div class="mt-8 overflow-hidden rounded-2xl ring-1 ring-slate-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-100">
                            <tr>
                                <th class="px-4 py-3 text-left text-sm font-bold text-slate-700">Día</th>
                                <th class="px-4 py-3 text-left text-sm font-bold text-slate-700">Horario</th>
                                <th class="px-4 py-3 text-left text-sm font-bold text-slate-700">Consultorio</th>
                                <th class="px-4 py-3 text-left text-sm font-bold text-slate-700">Estado</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-200 bg-white">
                            @forelse ($citas as $cita)
                            <tr>
                                <td class="px-4 py-4 font-semibold text-slate-900">{{ $cita->dia_semana }}</td>
                                <td class="px-4 py-4 text-sm text-slate-600">{{ $cita->hora_inicio }} - {{ $cita->hora_fin }}</td>
                                <td class="px-4 py-4 text-sm text-slate-600">{{ $cita->consultorio }}</td>
                                <td class="px-4 py-4">
                                    <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700 ring-1 ring-amber-600/20">
                                        Reservado
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-4 py-10 text-center text-slate-500">
                                    Aún no tienes citas reservadas por pacientes.
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