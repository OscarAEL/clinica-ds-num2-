@extends('layouts.dashboard')

@section('titulo', 'Médicos')
@section('header', 'Médicos Disponibles')

@section('content')
<div class="space-y-5">

    <p class="text-sm text-gray-500">Conoce el equipo médico profesional de Clínica DS.</p>

    <div class="grid gap-5 md:grid-cols-2">
        @forelse($medicos as $medico)
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5 hover:border-cyan-400 hover:shadow-md transition duration-200">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl bg-cyan-100 text-cyan-700 flex items-center justify-center font-bold text-lg flex-shrink-0">
                    {{ strtoupper(substr($medico->nombres, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="font-bold text-gray-900 text-sm">
                        Dr. {{ $medico->nombres }} {{ $medico->apellidos }}
                    </h3>
                    <p class="text-cyan-700 text-xs font-semibold mt-0.5">
                        {{ $medico->especialidad->nombre ?? 'Especialidad no asignada' }}
                    </p>
                    <div class="mt-2">
                        @if($medico->estado === 'activo')
                        <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 text-xs font-semibold px-2 py-0.5 rounded-full">
                            <i class="fa-solid fa-circle text-[7px]"></i> Disponible
                        </span>
                        @else
                        <span class="inline-flex items-center gap-1 bg-red-50 text-red-600 text-xs font-semibold px-2 py-0.5 rounded-full">
                            <i class="fa-solid fa-circle text-[7px]"></i> No disponible
                        </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100 space-y-1.5 text-sm text-gray-500">
                <p><i class="fa-solid fa-envelope w-4 mr-1 text-gray-400"></i>{{ $medico->user->email ?? 'No registrado' }}</p>
                <p><i class="fa-solid fa-phone w-4 mr-1 text-gray-400"></i>{{ $medico->telefono ?? 'No registrado' }}</p>
            </div>
        </div>
        @empty
        <div class="md:col-span-2 py-14 text-center">
            <div class="flex flex-col items-center gap-3 text-gray-400">
                <i class="fa-solid fa-user-doctor text-4xl"></i>
                <p class="text-sm font-medium">No hay médicos disponibles por el momento.</p>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection