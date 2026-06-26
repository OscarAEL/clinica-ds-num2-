@extends('layouts.dashboard')

@section('titulo', 'Nuevo Horario')
@section('header', 'Registrar Horario')

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
            <p class="text-white font-semibold">Nuevo horario de atención</p>
            <p class="text-cyan-200 text-xs mt-0.5">Agrega un bloque de disponibilidad para tus pacientes.</p>
        </div>

        <form action="{{ route('medico.horarios.store') }}" method="POST" class="p-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Día de atención</label>
                    <select name="dia_semana"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100">
                        @foreach(['Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo'] as $dia)
                        <option value="{{ $dia }}" {{ old('dia_semana') == $dia ? 'selected' : '' }}>
                            {{ $dia }}
                        </option>
                        @endforeach
                    </select>
                    @error('dia_semana')
                    <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Hora inicio</label>
                    <input type="time" name="hora_inicio" value="{{ old('hora_inicio') }}" required
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100">
                    @error('hora_inicio')
                    <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Hora fin</label>
                    <input type="time" name="hora_fin" value="{{ old('hora_fin') }}" required
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100">
                    @error('hora_fin')
                    <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Consultorio</label>
                    <input type="text" name="consultorio" value="{{ old('consultorio') }}"
                        placeholder="Ejemplo: Consultorio 201"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100">
                    @error('consultorio')
                    <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Estado</label>
                    <select name="estado"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100">
                        <option value="disponible" {{ old('estado') == 'disponible' ? 'selected' : '' }}>Disponible</option>
                        <option value="no_disponible" {{ old('estado') == 'no_disponible' ? 'selected' : '' }}>No disponible</option>
                    </select>
                    @error('estado')
                    <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

            </div>

            <div class="flex gap-3 mt-6 pt-5 border-t border-gray-100">
                <button type="submit"
                    class="bg-cyan-700 hover:bg-cyan-600 text-white font-semibold px-6 py-2.5 rounded-xl text-sm transition duration-200">
                    <i class="fa-solid fa-floppy-disk mr-2"></i>Guardar horario
                </button>
                <a href="{{ route('medico.horarios.index') }}"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-6 py-2.5 rounded-xl text-sm transition duration-200">
                    Cancelar
                </a>
            </div>

        </form>
    </div>
</div>
@endsection