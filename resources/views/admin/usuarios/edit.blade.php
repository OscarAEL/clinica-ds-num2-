@extends('layouts.dashboard')

@section('titulo', 'Editar Perfil')
@section('header', 'Modificar Rol de Usuario')

@section('content')
<div class="max-w-2xl mx-auto space-y-5">

    @if($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-xl text-sm">
        @foreach($errors->all() as $error)
        <p><i class="fa-solid fa-triangle-exclamation mr-2"></i>{{ $error }}</p>
        @endforeach
    </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">

        <div class="bg-cyan-700 px-6 py-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-full bg-cyan-600 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                {{ strtoupper(substr($usuario->name, 0, 1)) }}
            </div>
            <div>
                <p class="text-white font-semibold">{{ $usuario->name }}</p>
                <p class="text-cyan-200 text-xs">{{ $usuario->email }}</p>
            </div>
        </div>

        <form action="{{ route('admin.usuarios.update', $usuario->id) }}" method="POST" class="p-6 space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nombre completo</label>
                <input type="text" value="{{ $usuario->name }}" disabled
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50 text-gray-400 cursor-not-allowed">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Correo electrónico</label>
                <input type="email" value="{{ $usuario->email }}" disabled
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50 text-gray-400 cursor-not-allowed">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Tipo de usuario (Perfil)</label>
                <select name="tipo_usuario" required
                    class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100">
                    <option value="paciente" {{ old('tipo_usuario', $usuario->tipo_usuario) === 'paciente' ? 'selected' : '' }}>
                        Paciente
                    </option>
                    <option value="medico" {{ old('tipo_usuario', $usuario->tipo_usuario) === 'medico' ? 'selected' : '' }}>
                        Médico
                    </option>
                    <option value="administrador" {{ old('tipo_usuario', $usuario->tipo_usuario) === 'administrador' ? 'selected' : '' }}>
                        Administrador
                    </option>
                </select>
                @error('tipo_usuario')
                <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex gap-3 pt-2 border-t border-gray-100">
                <button type="submit"
                    class="bg-cyan-700 hover:bg-cyan-600 text-white font-semibold px-6 py-2.5 rounded-xl text-sm transition duration-200">
                    <i class="fa-solid fa-floppy-disk mr-2"></i>Actualizar perfil
                </button>
                <a href="{{ route('admin.usuarios.index') }}"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-6 py-2.5 rounded-xl text-sm transition duration-200">
                    Cancelar
                </a>
            </div>

        </form>
    </div>
</div>
@endsection