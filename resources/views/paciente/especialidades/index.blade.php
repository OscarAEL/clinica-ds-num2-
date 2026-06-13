<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Especialidades - Clínica D.S.</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-900">

<main class="mx-auto max-w-7xl px-4 py-8">
    <section class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-semibold text-cyan-700">Panel paciente</p>
                <h1 class="mt-1 text-3xl font-bold text-slate-950">
                    Especialidades disponibles
                </h1>
                <p class="mt-2 text-slate-600">
                    Conoce las especialidades médicas disponibles en Clínica D.S.
                </p>
            </div>

            <a href="{{ route('paciente.home') }}"
               class="rounded-2xl bg-slate-100 px-5 py-3 text-center font-semibold text-slate-800 hover:bg-slate-200">
                Volver
            </a>
        </div>

        <div class="mt-8 grid gap-5 md:grid-cols-2">
            @forelse ($especialidades as $especialidad)
                <article class="rounded-3xl bg-slate-50 p-6 ring-1 ring-slate-200 transition hover:-translate-y-1 hover:bg-cyan-50 hover:shadow-md">
                    <div class="flex items-start gap-4">
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-cyan-100 text-3xl">
                            🩺
                        </div>

                        <div>
                            <h2 class="text-xl font-bold text-slate-950">
                                {{ $especialidad->nombre }}
                            </h2>

                            <span class="mt-2 inline-flex rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
                                Disponible
                            </span>
                        </div>
                    </div>

                    <div class="mt-5 space-y-3 text-sm leading-6 text-slate-700">
                        <p>
                            <span class="font-bold text-slate-900">Información:</span>
                            {{ $especialidad->descripcion }}
                        </p>

                        <p>
                            <span class="font-bold text-slate-900">Área de atención:</span>
                            {{ $especialidad->area }}
                        </p>
                    </div>
                </article>
            @empty
                <div class="rounded-3xl bg-slate-50 p-6 text-slate-600 ring-1 ring-slate-200">
                    No hay especialidades disponibles por el momento.
                </div>
            @endforelse
        </div>

    </section>
</main>

</body>
</html>