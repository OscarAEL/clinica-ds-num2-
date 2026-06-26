@extends('layouts.dashboard')

@section('titulo', 'Dashboard')
@section('header', 'Panel de Control')

@section('content')
<div class="space-y-6">

    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-cyan-600 via-cyan-500 to-teal-500 p-8 shadow-sm">
        <div class="absolute -top-12 -right-12 w-56 h-56 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-16 -left-10 w-48 h-48 bg-white/10 rounded-full blur-3xl"></div>
        <div class="relative flex items-center justify-between">
            <div>
                <p class="text-cyan-50/80 text-sm font-medium tracking-wide uppercase">Panel administrador</p>
                <h1 class="text-3xl font-bold text-white mt-1">¡Bienvenido, Administrador!</h1>
                <p class="text-cyan-50/90 mt-2 max-w-lg">Monitorea y gestiona el personal médico, especialidades y usuarios de Clínica DS.</p>
            </div>
            <div class="hidden md:flex w-20 h-20 rounded-2xl bg-white/15 backdrop-blur-sm items-center justify-center text-4xl text-white flex-shrink-0">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
            <div class="w-11 h-11 rounded-xl bg-cyan-50 text-cyan-600 flex items-center justify-center text-lg">
                <i class="fa-solid fa-user-doctor"></i>
            </div>
            <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mt-4">Médicos Activos</p>
            <h3 class="text-3xl font-black text-gray-800 mt-1">{{ $totalMedicos }}</h3>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
            <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">
                <i class="fa-solid fa-stethoscope"></i>
            </div>
            <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mt-4">Especialidades</p>
            <h3 class="text-3xl font-black text-gray-800 mt-1">{{ $totalEspecialidades }}</h3>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
            <div class="w-11 h-11 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-lg">
                <i class="fa-solid fa-users"></i>
            </div>
            <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mt-4">Total Usuarios</p>
            <h3 class="text-3xl font-black text-gray-800 mt-1">{{ $totalUsuarios }}</h3>
        </div>

    </div>

    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
        <h2 class="text-base font-bold text-gray-800 mb-4 flex items-center gap-2">
            <i class="fa-solid fa-bolt text-amber-500"></i>Accesos rápidos
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <a href="{{ route('admin.medicos.index') }}"
                class="group p-4 rounded-xl bg-gray-50 border border-gray-100 hover:border-cyan-300 hover:bg-cyan-50/50 transition duration-200 block">
                <div class="w-9 h-9 rounded-lg bg-cyan-100 text-cyan-700 flex items-center justify-center mb-3">
                    <i class="fa-solid fa-user-doctor text-sm"></i>
                </div>
                <h4 class="font-bold text-gray-800 text-sm group-hover:text-cyan-700 transition">Gestión de Personal</h4>
                <p class="text-xs text-gray-500 mt-1">Alta, baja y modificación de médicos.</p>
            </a>

            <a href="{{ route('admin.especialidades.index') }}"
                class="group p-4 rounded-xl bg-gray-50 border border-gray-100 hover:border-cyan-300 hover:bg-cyan-50/50 transition duration-200 block">
                <div class="w-9 h-9 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center mb-3">
                    <i class="fa-solid fa-stethoscope text-sm"></i>
                </div>
                <h4 class="font-bold text-gray-800 text-sm group-hover:text-cyan-700 transition">Especialidades</h4>
                <p class="text-xs text-gray-500 mt-1">Configura ramas de atención.</p>
            </a>

            <a href="{{ route('admin.usuarios.index') }}"
                class="group p-4 rounded-xl bg-gray-50 border border-gray-100 hover:border-cyan-300 hover:bg-cyan-50/50 transition duration-200 block">
                <div class="w-9 h-9 rounded-lg bg-purple-100 text-purple-700 flex items-center justify-center mb-3">
                    <i class="fa-solid fa-users text-sm"></i>
                </div>
                <h4 class="font-bold text-gray-800 text-sm group-hover:text-cyan-700 transition">Auditoría de Cuentas</h4>
                <p class="text-xs text-gray-500 mt-1">Supervisión de accesos de usuarios.</p>
            </a>

        </div>
    </div>

</div>
@endsection