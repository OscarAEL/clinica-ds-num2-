@extends('layouts.dashboard')

@section('titulo', 'Especialidades')
@section('header', 'Gestión de Especialidades')

@section('content')
<div class="space-y-5">

    <div class="flex items-center justify-between">
        <p class="text-sm text-gray-500">Registra y administra las especialidades médicas de Clínica DS.</p>
        <a href="{{ route('admin.especialidades.create') }}"
            class="bg-cyan-700 hover:bg-cyan-600 text-white font-semibold px-5 py-2.5 rounded-xl text-sm transition duration-200">
            <i class="fa-solid fa-plus mr-2"></i>Nueva especialidad
        </a>
    </div>

    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-xl text-sm font-medium">
        <i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}
    </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Especialidad</th>
                        <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Descripción</th>
                        <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($especialidades as $especialidad)
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-cyan-100 text-cyan-700 flex items-center justify-center flex-shrink-0">
                                    <i class="fa-solid fa-stethoscope text-sm"></i>
                                </div>
                                <span class="font-semibold text-gray-900 text-sm">{{ $especialidad->nombre }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-sm text-gray-500 max-w-xs truncate">
                            {{ $especialidad->descripcion ?? '—' }}
                        </td>
                        <td class="px-5 py-4">
                            @if($especialidad->estado === 'activo')
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
                            <a href="{{ route('admin.especialidades.edit', $especialidad->id) }}"
                                class="inline-flex items-center gap-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold px-4 py-2 rounded-xl transition duration-150">
                                <i class="fa-solid fa-pen-to-square text-xs"></i> Editar
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-5 py-14 text-center">
                            <div class="flex flex-col items-center gap-3 text-gray-400">
                                <i class="fa-solid fa-stethoscope text-4xl"></i>
                                <p class="text-sm font-medium">No hay especialidades registradas todavía.</p>
                                <a href="{{ route('admin.especialidades.create') }}"
                                    class="text-cyan-600 hover:underline text-sm font-semibold">
                                    Registrar primera especialidad
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection