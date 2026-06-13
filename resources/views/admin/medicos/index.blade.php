<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Médicos - Clínica D.S.</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-900">

    <main class="mx-auto max-w-7xl px-4 py-8">

        <section class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm font-semibold text-cyan-700">Panel administrador</p>
                    <h1 class="mt-1 text-3xl font-bold text-slate-950">
                        Gestión de médicos
                    </h1>
                    <p class="mt-2 text-slate-600">
                        Registra, edita y administra los médicos de Clínica D.S.
                    </p>
                </div>

                <div class="flex flex-col gap-2 sm:flex-row">
                    <a href="{{ route('admin.home') }}"
                       class="rounded-2xl bg-slate-100 px-5 py-3 text-center font-semibold text-slate-800 hover:bg-slate-200">
                        Volver al panel
                    </a>

                    <a href="{{ route('admin.medicos.create') }}"
                       class="rounded-2xl bg-cyan-600 px-5 py-3 text-center font-semibold text-white hover:bg-cyan-700">
                        Nuevo médico
                    </a>
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
                                <th class="px-4 py-3 text-left text-sm font-bold text-slate-700">Correo</th>
                                <th class="px-4 py-3 text-left text-sm font-bold text-slate-700">Especialidad</th>
                                <th class="px-4 py-3 text-left text-sm font-bold text-slate-700">Teléfono</th>
                                <th class="px-4 py-3 text-left text-sm font-bold text-slate-700">Estado</th>
                                <th class="px-4 py-3 text-right text-sm font-bold text-slate-700">Acciones</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-200 bg-white">
                            @forelse ($medicos as $medico)
                                <tr>
                                    <td class="px-4 py-4">
                                        <p class="font-semibold text-slate-950">
                                            {{ $medico->nombres }} {{ $medico->apellidos }}
                                        </p>
                                        <p class="text-sm text-slate-500">
                                            CMP: {{ $medico->cmp ?? 'No registrado' }}
                                        </p>
                                    </td>

                                    <td class="px-4 py-4 text-sm text-slate-600">
                                        {{ $medico->user->email }}
                                    </td>

                                    <td class="px-4 py-4 text-sm text-slate-600">
                                        {{ $medico->especialidad }}
                                    </td>

                                    <td class="px-4 py-4 text-sm text-slate-600">
                                        {{ $medico->telefono ?? 'No registrado' }}
                                    </td>

                                    <td class="px-4 py-4">
                                        @if ($medico->estado === 'activo')
                                            <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
                                                Activo
                                            </span>
                                        @else
                                            <span class="rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-700">
                                                Inactivo
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-4 py-4">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('admin.medicos.edit', $medico) }}"
                                               class="rounded-xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-200">
                                                Editar
                                            </a>

                                            <form action="{{ route('admin.medicos.destroy', $medico) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('¿Seguro que deseas eliminar este médico?')">
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
                                    <td colspan="6" class="px-4 py-10 text-center text-slate-500">
                                        Todavía no hay médicos registrados.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6">
                {{ $medicos->links() }}
            </div>

        </section>

    </main>

</body>
</html>