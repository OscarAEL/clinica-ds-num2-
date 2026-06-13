<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Médico - Clínica D.S.</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-900">

    <main class="mx-auto max-w-5xl px-4 py-8">
        <section class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-slate-950">
                        Panel del médico
                    </h1>

                    <p class="mt-3 text-slate-600">
                        Bienvenido médico. Desde aquí puedes gestionar tus horarios,
                        revisar tus citas y visualizar tu perfil profesional.
                    </p>
                </div>

                <div class="rounded-2xl bg-cyan-50 px-5 py-4 text-cyan-700 ring-1 ring-cyan-100">
                    <p class="text-sm font-semibold">Usuario médico</p>
                    <p class="text-sm">{{ Auth::user()->email }}</p>
                </div>
            </div>

            <div class="mt-8 grid gap-4 md:grid-cols-3">

                <a href="{{ route('medico.horarios.index') }}"
                   class="block rounded-2xl bg-slate-50 p-5 ring-1 ring-slate-200 transition hover:-translate-y-1 hover:bg-cyan-50 hover:shadow-md">
                    <div class="mb-3 text-3xl">📅</div>
                    <h2 class="font-bold text-slate-950">
                        Mis horarios
                    </h2>
                    <p class="mt-2 text-sm leading-6 text-slate-600">
                        Gestiona tus días, horas disponibles y consultorio.
                    </p>
                </a>

                <a href="{{ route('medico.citas.index') }}"
                   class="block rounded-2xl bg-slate-50 p-5 ring-1 ring-slate-200 transition hover:-translate-y-1 hover:bg-cyan-50 hover:shadow-md">
                    <div class="mb-3 text-3xl">🩺</div>
                    <h2 class="font-bold text-slate-950">
                        Mis citas
                    </h2>
                    <p class="mt-2 text-sm leading-6 text-slate-600">
                        Revisa las citas programadas por tus pacientes.
                    </p>
                </a>

                <a href="{{ route('medico.perfil') }}"
                   class="block rounded-2xl bg-slate-50 p-5 ring-1 ring-slate-200 transition hover:-translate-y-1 hover:bg-cyan-50 hover:shadow-md">
                    <div class="mb-3 text-3xl">👨‍⚕️</div>
                    <h2 class="font-bold text-slate-950">
                        Mi perfil
                    </h2>
                    <p class="mt-2 text-sm leading-6 text-slate-600">
                        Visualiza y actualiza tu información profesional.
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