<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios - Clínica D.S.</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-900">

    <main class="mx-auto max-w-7xl px-4 py-8">
        <section class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm font-semibold text-cyan-700">Panel administrador</p>
                    <h1 class="mt-1 text-3xl font-bold text-slate-950">
                        Gestión de usuarios y perfiles
                    </h1>
                    <p class="mt-2 text-slate-600">
                        Supervisa las cuentas de usuarios registradas en el sistema y administra sus tipos de perfil.
                    </p>
                </div>

                <div class="flex flex-col gap-2 sm:flex-row">
                    <a href="{{ route('admin.home') }}"
                        class="rounded-2xl bg-slate-100 px-5 py-3 text-center font-semibold text-slate-800 hover:bg-slate-200">
                        Volver al panel
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
                                <th class="px-4 py-3 text-left text-sm font-bold text-slate-700">Nombre de Usuario</th>
                                <th class="px-4 py-3 text-left text-sm font-bold text-slate-700">Correo Electrónico</th>
                                <th class="px-4 py-3 text-left text-sm font-bold text-slate-700">Tipo de Usuario (Perfil)</th>
                                <th class="px-4 py-3 text-right text-sm font-bold text-slate-700">Acciones</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-200 bg-white">
                            @forelse ($usuarios as $usuario)
                            <tr>
                                <td class="px-4 py-4 font-semibold text-slate-950">
                                    {{ $usuario->name }}
                                </td>

                                <td class="px-4 py-4 text-sm text-slate-600">
                                    {{ $usuario->email }}
                                </td>

                                <td class="px-4 py-4">
                                    @if ($usuario->tipo_usuario === 'administrador')
                                    <span class="rounded-full bg-cyan-50 px-3 py-1 text-xs font-semibold text-cyan-700 uppercase">
                                        {{ $usuario->tipo_usuario }}
                                    </span>
                                    @elseif ($usuario->tipo_usuario === 'medico')
                                    <span class="rounded-full bg-purple-50 px-3 py-1 text-xs font-semibold text-purple-700 uppercase">
                                        {{ $usuario->tipo_usuario }}
                                    </span>
                                    @else
                                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700 uppercase">
                                        {{ $usuario->tipo_usuario }}
                                    </span>
                                    @endif
                                </td>

                                <td class="px-4 py-4">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('admin.usuarios.edit', $usuario->id) }}"
                                            class="rounded-xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-200">
                                            Editar Perfil
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-4 py-10 text-center text-slate-500">
                                    No hay usuarios registrados en la base de datos.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6 rounded-2xl bg-slate-100 p-4 text-sm text-slate-600 ring-1 ring-slate-200">
                Sistema conectado a la base de datos persistente SQLite. Los cambios se guardan de forma segura.
            </div>

        </section>
    </main>

</body>

</html>