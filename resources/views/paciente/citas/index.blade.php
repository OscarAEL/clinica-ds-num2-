<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Citas - Clínica D.S.</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-900">

<main class="mx-auto max-w-7xl px-4 py-8">
    <section class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-semibold text-cyan-700">Panel paciente</p>
                <h1 class="mt-1 text-3xl font-bold text-slate-950">Citas disponibles</h1>
                <p class="mt-2 text-slate-600">
                    Revisa los horarios disponibles publicados por los médicos de la clínica.
                </p>
            </div>

            <a href="{{ route('paciente.home') }}"
               class="rounded-2xl bg-slate-100 px-5 py-3 text-center font-semibold text-slate-800 hover:bg-slate-200">
                Volver
            </a>
        </div>

        @if (session('success'))
            <div class="mt-6 rounded-2xl bg-emerald-50 p-4 text-sm font-semibold text-emerald-700 ring-1 ring-emerald-100">
                {{ session('success') }}
            </div>
        @endif

        <div class="mt-8 grid gap-4 md:grid-cols-2">
            @forelse ($disponibilidades as $item)
                <article class="rounded-3xl bg-slate-50 p-5 ring-1 ring-slate-200">
                    <h2 class="text-xl font-bold text-slate-950">
                        {{ $item->medico }}
                    </h2>

                    <p class="mt-1 text-sm font-semibold text-cyan-700">
                        {{ $item->especialidad }}
                    </p>

                    <div class="mt-4 grid gap-2 text-sm text-slate-700">
                        <p><strong>Día:</strong> {{ $item->dia }}</p>
                        <p><strong>Fecha:</strong> {{ $item->fecha }}</p>
                        <p><strong>Horario:</strong> {{ $item->hora_inicio }} - {{ $item->hora_fin }}</p>
                        <p><strong>Lugar:</strong> {{ $item->lugar }}</p>
                        <p><strong>Laboratorio:</strong> {{ $item->laboratorio }}</p>
                    </div>

                    <div class="mt-5">
                        @if ($item->estado === 'disponible')
                            <form action="{{ route('paciente.citas.reservar', $item->id) }}" method="POST">
                                @csrf

                                <button class="rounded-2xl bg-cyan-600 px-5 py-3 font-semibold text-white hover:bg-cyan-700">
                                    Reservar cita
                                </button>
                            </form>
                        @else
                            <span class="rounded-full bg-amber-50 px-4 py-2 text-sm font-semibold text-amber-700">
                                Reservado por {{ $item->paciente }}
                            </span>
                        @endif
                    </div>
                </article>
            @empty
                <div class="rounded-3xl bg-slate-50 p-6 text-slate-600 ring-1 ring-slate-200">
                    No hay horarios disponibles por el momento.
                </div>
            @endforelse
        </div>

    </section>
</main>

</body>
</html>