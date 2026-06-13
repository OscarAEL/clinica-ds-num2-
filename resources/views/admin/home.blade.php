<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Administrador - Clínica D.S.</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-900">

    <main class="mx-auto max-w-5xl px-4 py-8">
        <section class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-slate-950">
                        Panel de administrador
                    </h1>

                    <p class="mt-3 text-slate-600">
                        Bienvenido administrador. Desde aquí podrás gestionar médicos,
                        especialidades, usuarios y supervisar la información general de la clínica.
                    </p>
                </div>

                <div class="rounded-2xl bg-cyan-50 px-5 py-4 text-cyan-700 ring-1 ring-cyan-100">
                    <p class="text-sm font-semibold">Usuario administrador</p>
                    <p class="text-sm">{{ Auth::user()->email }}</p>
                </div>
            </div>

            <div class="mt-8 grid gap-4 md:grid-cols-3">

                {{-- MÉDICOS --}}
                <a href="{{ route('admin.medicos.index') }}"
                   class="block rounded-2xl bg-slate-50 p-5 ring-1 ring-slate-200 transition hover:-translate-y-1 hover:bg-cyan-50 hover:shadow-md">
                    <div class="mb-3 text-3xl">👨‍⚕️</div>

                    <h2 class="font-bold text-slate-950">
                        Médicos
                    </h2>

                    <p class="mt-2 text-sm leading-6 text-slate-600">
                        Registrar, editar y eliminar médicos.
                    </p>
                </a>

                {{-- ESPECIALIDADES --}}
                <a href="{{ route('admin.especialidades.index') }}"
                   class="block rounded-2xl bg-slate-50 p-5 ring-1 ring-slate-200 transition hover:-translate-y-1 hover:bg-cyan-50 hover:shadow-md">
                    <div class="mb-3 text-3xl">🩺</div>

                    <h2 class="font-bold text-slate-950">
                        Especialidades
                    </h2>

                    <p class="mt-2 text-sm leading-6 text-slate-600">
                        Registrar, editar y eliminar especialidades.
                    </p>
                </a>

                {{-- GESTIÓN DE USUARIOS --}}
                <a href="{{ route('admin.usuarios.index') }}"
                   class="block rounded-2xl bg-slate-50 p-5 ring-1 ring-slate-200 transition hover:-translate-y-1 hover:bg-cyan-50 hover:shadow-md">
                    <div class="mb-3 text-3xl">👥</div>

                    <h2 class="font-bold text-slate-950">
                        Gestión de usuarios
                    </h2>

                    <p class="mt-2 text-sm leading-6 text-slate-600">
                        Ver administradores, médicos y pacientes registrados.
                    </p>
                </a>

            </div>

            <form action="{{ route('logout') }}" method="POST" class="mt-8">
                @csrf

                <button class="rounded-2xl bg-red-600 px-5 py-3 font-semibold text-white hover:bg-red-700">
                    Cerrar sesión
                </button>
            </form>

        </section>
    </main>

</body>
</html>