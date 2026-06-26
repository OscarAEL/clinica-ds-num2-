@extends('layouts.dashboard')

@section('titulo', 'Inicio')
@section('header', 'Panel de Control')

@section('content')
<div class="space-y-6">

    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-cyan-600 via-cyan-500 to-teal-500 p-8 shadow-sm">
        <div class="absolute -top-12 -right-12 w-56 h-56 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-16 -left-10 w-48 h-48 bg-white/10 rounded-full blur-3xl"></div>

        <div class="relative flex items-center justify-between">
            <div>
                <p class="text-cyan-50/80 text-sm font-medium tracking-wide uppercase">Panel paciente</p>
                <h1 class="text-3xl font-bold text-white mt-1">¡Hola, {{ Auth::user()->name }}!</h1>
                <p class="text-cyan-50/90 mt-2 max-w-lg">Bienvenido a tu portal de salud. Agenda tus citas en pasos sencillos.</p>
            </div>
            <div class="hidden md:flex w-20 h-20 rounded-2xl bg-white/15 backdrop-blur-sm items-center justify-center text-4xl text-white flex-shrink-0">
                <i class="fa-solid fa-heart-pulse"></i>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        {{-- Próxima cita: conectada a datos reales --}}
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-start gap-4">
            <div class="w-11 h-11 rounded-xl bg-cyan-50 text-cyan-600 flex items-center justify-center text-lg flex-shrink-0">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
            <div>
                <h4 class="font-bold text-gray-800 text-sm">Próxima cita médica</h4>
                @if($proximaCita)
                <p class="text-xs text-cyan-700 font-semibold mt-1">
                    Dr. {{ $proximaCita->horario->medico->nombres }}
                    {{ $proximaCita->horario->medico->apellidos }}
                </p>
                <p class="text-xs text-gray-500 mt-0.5">
                    {{ \Carbon\Carbon::parse($proximaCita->fecha)->locale('es')->isoFormat('dddd D [de] MMMM') }}
                    · {{ substr($proximaCita->horario->hora_inicio, 0, 5) }}
                </p>
                @else
                <p class="text-xs text-gray-500 mt-1">No tienes citas próximas confirmadas.</p>
                @endif
            </div>
        </div>

        {{-- Historial --}}
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-start gap-4">
            <div class="w-11 h-11 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-lg flex-shrink-0">
                <i class="fa-solid fa-laptop-medical"></i>
            </div>
            <div>
                <h4 class="font-bold text-gray-800 text-sm">Historial rápido</h4>
                <p class="text-xs text-gray-500 mt-1">Revisa tus consultas anteriores en el menú lateral.</p>
            </div>
        </div>

        {{-- CTA Reservar --}}
        <a href="{{ route('paciente.citas.index') }}"
            class="bg-cyan-700 hover:bg-cyan-600 transition duration-200 p-6 rounded-2xl shadow-sm flex items-start gap-4 text-white">
            <div class="w-11 h-11 rounded-xl bg-white/15 flex items-center justify-center text-lg flex-shrink-0">
                <i class="fa-solid fa-plus"></i>
            </div>
            <div>
                <h4 class="font-bold text-sm">Reservar nueva cita</h4>
                <p class="text-xs text-cyan-50/90 mt-1">Inicia tu solicitud por pasos guiados.</p>
            </div>
        </a>

    </div>
</div>
@endsection