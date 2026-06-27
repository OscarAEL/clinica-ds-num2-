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
                <p class="text-cyan-50/80 text-sm font-medium tracking-wide uppercase">Panel médico</p>
                <h1 class="text-3xl font-bold text-white mt-1">Bienvenido, Dr. {{ Auth::user()->name }}</h1>
                <p class="text-cyan-50/90 mt-2 max-w-lg">Mantén el control de tus atenciones del día y solicitudes pendientes.</p>
            </div>
            <div class="hidden md:flex w-20 h-20 rounded-2xl bg-white/15 backdrop-blur-sm items-center justify-center text-4xl text-white flex-shrink-0">
                <i class="fa-solid fa-user-doctor"></i>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
            <div class="w-11 h-11 rounded-xl bg-cyan-50 text-cyan-600 flex items-center justify-center text-lg">
                <i class="fa-solid fa-calendar-day"></i>
            </div>
            <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mt-4">Citas para Hoy</p>
            <h3 class="text-3xl font-black text-gray-800 mt-1">{{ $citasHoy }}</h3>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
            <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
            <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mt-4">Citas Reservadas</p>
            <h3 class="text-3xl font-black text-gray-800 mt-1">{{ $citasTotal }}</h3>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
            <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg">
                <i class="fa-solid fa-hourglass-half"></i>
            </div>
            <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mt-4">Mis Horarios</p>
            <h3 class="text-3xl font-black text-gray-800 mt-1">
                {{ $horariosDisponibles }}
            </h3>
        </div>

    </div>
</div>
@endsection