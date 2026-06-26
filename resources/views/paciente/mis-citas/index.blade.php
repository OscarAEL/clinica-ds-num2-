@extends('layouts.dashboard')

@section('titulo', 'Mis Citas')
@section('header', 'Mis Citas')

@section('content')
<div class="space-y-5">

    <p class="text-sm text-gray-500">Historial de tus reservas médicas en Clínica DS.</p>

    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-xl text-sm font-medium">
        <i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}
    </div>
    @endif

    @forelse($citas as $cita)
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5">
        <div class="flex items-start justify-between gap-4">

            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl bg-cyan-100 text-cyan-700 flex items-center justify-center flex-shrink-0 text-lg">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>
                <div>
                    <p class="font-bold text-gray-900">
                        Dr. {{ $cita->horario->medico->nombres ?? '—' }}
                        {{ $cita->horario->medico->apellidos ?? '' }}
                    </p>
                    <p class="text-sm text-cyan-700 font-semibold mt-0.5">
                        {{ $cita->horario->medico->especialidad->nombre ?? '—' }}
                    </p>
                    <div class="mt-2 flex flex-wrap gap-3 text-xs text-gray-500">
                        <span>
                            <i class="fa-solid fa-calendar mr-1"></i>
                            {{ \Carbon\Carbon::parse($cita->fecha)->locale('es')->isoFormat('dddd D [de] MMMM [de] YYYY') }}
                        </span>
                        <span>
                            <i class="fa-solid fa-clock mr-1"></i>
                            {{ substr($cita->horario->hora_inicio, 0, 5) }} –
                            {{ substr($cita->horario->hora_fin, 0, 5) }}
                        </span>
                        @if($cita->horario->consultorio)
                        <span>
                            <i class="fa-solid fa-door-open mr-1"></i>
                            {{ $cita->horario->consultorio }}
                        </span>
                        @endif
                    </div>
                    @if($cita->motivo_consulta)
                    <p class="text-xs text-gray-400 mt-2">
                        <i class="fa-solid fa-note-sticky mr-1"></i>
                        {{ $cita->motivo_consulta }}
                    </p>
                    @endif
                    @if($cita->motivo_cancelacion)
                    <p class="text-xs text-red-500 mt-2">
                        <i class="fa-solid fa-triangle-exclamation mr-1"></i>
                        Motivo: {{ $cita->motivo_cancelacion }}
                    </p>
                    @endif
                </div>
            </div>

            {{-- Badge de estado --}}
            <div class="flex-shrink-0">
                @if($cita->estado === 'reservada')
                <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 text-xs font-semibold px-3 py-1.5 rounded-full">
                    <i class="fa-solid fa-circle text-[7px]"></i> Reservada
                </span>
                @elseif($cita->estado === 'cancelada')
                <span class="inline-flex items-center gap-1.5 bg-red-50 text-red-600 text-xs font-semibold px-3 py-1.5 rounded-full">
                    <i class="fa-solid fa-circle text-[7px]"></i> Cancelada
                </span>
                @elseif($cita->estado === 'reprogramada')
                <span class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-700 text-xs font-semibold px-3 py-1.5 rounded-full">
                    <i class="fa-solid fa-circle text-[7px]"></i> Reprogramada
                </span>
                @endif
            </div>

        </div>
    </div>
    @empty
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm py-16 text-center">
        <div class="flex flex-col items-center gap-3 text-gray-400">
            <i class="fa-solid fa-calendar-xmark text-5xl"></i>
            <p class="font-medium text-gray-500">No tienes citas registradas todavía.</p>
            <a href="{{ route('paciente.citas.index') }}"
                class="mt-2 bg-cyan-700 hover:bg-cyan-600 text-white font-semibold px-6 py-2.5 rounded-xl text-sm transition duration-200">
                <i class="fa-solid fa-plus mr-2"></i>Reservar mi primera cita
            </a>
        </div>
    </div>
    @endforelse

</div>
@endsection