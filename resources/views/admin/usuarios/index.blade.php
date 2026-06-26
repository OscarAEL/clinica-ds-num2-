@extends('layouts.dashboard')

@section('titulo', 'Usuarios')
@section('header', 'Gestión de Usuarios y Perfiles')

@section('content')
<div class="space-y-5">

    <p class="text-sm text-gray-500">Supervisa las cuentas registradas y administra sus tipos de perfil.</p>

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
                        <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Usuario</th>
                        <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Correo</th>
                        <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Perfil</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($usuarios as $usuario)
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-gray-200 text-gray-600 flex items-center justify-center font-bold text-sm flex-shrink-0">
                                    {{ strtoupper(substr($usuario->name, 0, 1)) }}
                                </div>
                                <span class="font-semibold text-gray-900 text-sm">{{ $usuario->name }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-sm text-gray-500">
                            {{ $usuario->email }}
                        </td>
                        <td class="px-5 py-4">
                            @if($usuario->tipo_usuario === 'administrador')
                            <span class="inline-flex items-center bg-cyan-50 text-cyan-700 text-xs font-semibold px-3 py-1 rounded-full uppercase">
                                <i class="fa-solid fa-shield-halved mr-1.5 text-[10px]"></i>{{ $usuario->tipo_usuario }}
                            </span>
                            @elseif($usuario->tipo_usuario === 'medico')
                            <span class="inline-flex items-center bg-purple-50 text-purple-700 text-xs font-semibold px-3 py-1 rounded-full uppercase">
                                <i class="fa-solid fa-user-doctor mr-1.5 text-[10px]"></i>{{ $usuario->tipo_usuario }}
                            </span>
                            @else
                            <span class="inline-flex items-center bg-gray-100 text-gray-600 text-xs font-semibold px-3 py-1 rounded-full uppercase">
                                <i class="fa-solid fa-user mr-1.5 text-[10px]"></i>{{ $usuario->tipo_usuario }}
                            </span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-right">
                            <a href="{{ route('admin.usuarios.edit', $usuario->id) }}"
                                class="inline-flex items-center gap-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold px-4 py-2 rounded-xl transition duration-150">
                                <i class="fa-solid fa-pen-to-square text-xs"></i> Editar perfil
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-5 py-14 text-center">
                            <div class="flex flex-col items-center gap-3 text-gray-400">
                                <i class="fa-solid fa-users text-4xl"></i>
                                <p class="text-sm font-medium">No hay usuarios registrados.</p>
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