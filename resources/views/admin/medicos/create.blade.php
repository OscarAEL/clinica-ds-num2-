@extends('layouts.dashboard')

@section('titulo', 'Registrar Médico')
@section('header', 'Registrar Nuevo Médico')

@section('content')
<div class="max-w-3xl mx-auto space-y-5">

    @if($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-xl text-sm">
        @foreach($errors->all() as $error)
        <p><i class="fa-solid fa-triangle-exclamation mr-2"></i>{{ $error }}</p>
        @endforeach
    </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">

        <div class="bg-cyan-700 px-6 py-4">
            <p class="text-white font-semibold">Datos del médico</p>
            <p class="text-cyan-200 text-xs mt-0.5">También se creará su usuario para iniciar sesión.</p>
        </div>

        <form action="{{ route('admin.medicos.store') }}" method="POST" class="p-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nombres</label>
                    <input type="text" name="nombres" value="{{ old('nombres') }}" required
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100">
                    @error('nombres')
                    <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Apellidos</label>
                    <input type="text" name="apellidos" value="{{ old('apellidos') }}" required
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100">
                    @error('apellidos')
                    <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Correo</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        placeholder="medico@clinicads.com"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100">
                    @error('email')
                    <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Contraseña</label>
                    <input type="password" name="password" required
                        placeholder="Mínimo 6 caracteres"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100">
                    @error('password')
                    <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">DNI</label>
                    <input type="text" name="dni" value="{{ old('dni') }}"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100">
                    @error('dni')
                    <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Teléfono</label>
                    <input type="text" name="telefono" value="{{ old('telefono') }}"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100">
                    @error('telefono')
                    <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Especialidad</label>
                    <select name="especialidad_id" required
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100">
                        <option value="">-- Selecciona una especialidad --</option>
                        @foreach($especialidades as $especialidad)
                        <option value="{{ $especialidad->id }}"
                            {{ old('especialidad_id') == $especialidad->id ? 'selected' : '' }}>
                            {{ $especialidad->nombre }}
                        </option>
                        @endforeach
                    </select>
                    @error('especialidad_id')
                    <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">CMP</label>
                    <input type="text" name="cmp" value="{{ old('cmp') }}"
                        placeholder="Código médico"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100">
                    @error('cmp')
                    <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Estado</label>
                    <select name="estado"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100">
                        <option value="activo" {{ old('estado') === 'activo' ? 'selected' : '' }}>Activo</option>
                        <option value="inactivo" {{ old('estado') === 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                    @error('estado')
                    <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

            </div>

            <div class="flex gap-3 mt-6 pt-5 border-t border-gray-100">
                <button type="submit"
                    class="bg-cyan-700 hover:bg-cyan-600 text-white font-semibold px-6 py-2.5 rounded-xl text-sm transition duration-200">
                    <i class="fa-solid fa-floppy-disk mr-2"></i>Guardar médico
                </button>
                <a href="{{ route('admin.medicos.index') }}"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-6 py-2.5 rounded-xl text-sm transition duration-200">
                    Cancelar
                </a>
            </div>

        </form>
    </div>
</div>
@endsection