@extends('layouts.dashboard')

@section('titulo', 'Nueva Especialidad')
@section('header', 'Registrar Especialidad')

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

        <div class="bg-cyan-700 px-6 py-4">
            <p class="text-white font-semibold">Nueva especialidad médica</p>
            <p class="text-cyan-200 text-xs mt-0.5">Completa los datos para agregar una nueva especialidad.</p>
        </div>

        <form action="{{ route('admin.especialidades.store') }}" method="POST" class="p-6 space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nombre de la especialidad</label>
                <input type="text" name="nombre" value="{{ old('nombre') }}" required
                    placeholder="Ejemplo: Cardiología"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100">
                @error('nombre')
                <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Descripción</label>
                <textarea name="descripcion" rows="4"
                    placeholder="Describe brevemente la especialidad"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100">{{ old('descripcion') }}</textarea>
                @error('descripcion')
                <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div>
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

            <div class="flex gap-3 pt-2 border-t border-gray-100">
                <button type="submit"
                    class="bg-cyan-700 hover:bg-cyan-600 text-white font-semibold px-6 py-2.5 rounded-xl text-sm transition duration-200">
                    <i class="fa-solid fa-floppy-disk mr-2"></i>Guardar especialidad
                </button>
                <a href="{{ route('admin.especialidades.index') }}"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-6 py-2.5 rounded-xl text-sm transition duration-200">
                    Cancelar
                </a>
            </div>

        </form>
    </div>
</div>
@endsection