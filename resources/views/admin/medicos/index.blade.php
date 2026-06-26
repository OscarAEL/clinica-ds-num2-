@extends('layouts.dashboard')

@section('titulo', 'Gestión de Médicos')
@section('header', 'Gestión de Médicos')

@section('content')
<div class="space-y-5">

    {{-- Barra de acciones --}}
    <div class="flex items-center justify-between">
        <p class="text-sm text-gray-500">
            Registra, edita y administra los médicos de Clínica DS.
        </p>
        <a href="{{ route('admin.medicos.create') }}"
            class="bg-cyan-700 hover:bg-cyan-600 text-white font-semibold px-5 py-2.5 rounded-xl text-sm transition duration-200">
            <i class="fa-solid fa-plus mr-2"></i>Nuevo médico
        </a>
    </div>

    {{-- Mensaje de éxito --}}
    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-xl text-sm font-medium">
        <i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}
    </div>
    @endif

    {{-- Tabla --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Médico</th>
                        <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Correo</th>
                        <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Especialidad</th>
                        <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Teléfono</th>
                        <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($medicos as $medico)
                    <tr class="hover:bg-gray-50 transition duration-150">

                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-cyan-100 text-cyan-700 flex items-center justify-center font-bold text-sm flex-shrink-0">
                                    {{ strtoupper(substr($medico->nombres, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900 text-sm">
                                        {{ $medico->nombres }} {{ $medico->apellidos }}
                                    </p>
                                    <p class="text-xs text-gray-400">CMP: {{ $medico->cmp ?? 'No registrado' }}</p>
                                </div>
                            </div>
                        </td>

                        <td class="px-5 py-4 text-sm text-gray-600">
                            {{ $medico->user->email }}
                        </td>

                        <td class="px-5 py-4 text-sm text-gray-600">
                            {{ $medico->especialidad->nombre ?? 'Sin especialidad' }}
                        </td>

                        <td class="px-5 py-4 text-sm text-gray-600">
                            {{ $medico->telefono ?? 'No registrado' }}
                        </td>

                        <td class="px-5 py-4">
                            @if($medico->estado === 'activo')
                            <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 text-xs font-semibold px-3 py-1 rounded-full">
                                <i class="fa-solid fa-circle text-[8px]"></i> Activo
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1 bg-red-50 text-red-600 text-xs font-semibold px-3 py-1 rounded-full">
                                <i class="fa-solid fa-circle text-[8px]"></i> Inactivo
                            </span>
                            @endif
                        </td>

                        <td class="px-5 py-4 text-right">
                            <a href="{{ route('admin.medicos.edit', $medico) }}"
                                class="inline-flex items-center gap-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold px-4 py-2 rounded-xl transition duration-150">
                                <i class="fa-solid fa-pen-to-square text-xs"></i> Editar
                            </a>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-14 text-center">
                            <div class="flex flex-col items-center gap-3 text-gray-400">
                                <i class="fa-solid fa-user-doctor text-4xl"></i>
                                <p class="text-sm font-medium">No hay médicos registrados todavía.</p>
                                <a href="{{ route('admin.medicos.create') }}"
                                    class="text-cyan-600 hover:underline text-sm font-semibold">
                                    Registrar primer médico
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        @if($medicos->hasPages())
        <div class="px-5 py-4 border-t border-gray-100">
            {{ $medicos->links() }}
        </div>
        @endif

    </div>
</div>
@endsection