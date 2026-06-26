@extends('layouts.dashboard')

@section('titulo', 'Mi Perfil')
@section('header', 'Mi Perfil Profesional')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    {{-- Mensajes de feedback --}}
    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-xl text-sm font-medium">
        <i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-xl text-sm">
        @foreach($errors->all() as $error)
        <p><i class="fa-solid fa-triangle-exclamation mr-2"></i>{{ $error }}</p>
        @endforeach
    </div>
    @endif

    {{-- Tarjeta del formulario --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">

        {{-- Encabezado de tarjeta --}}
        <div class="bg-cyan-700 px-6 py-4 flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-blue-700 flex items-center justify-center text-white font-bold text-lg">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div>
                <p class="text-white font-semibold">{{ Auth::user()->name }}</p>
                <p class="text-blue-300 text-xs">{{ $medico->especialidad->nombre ?? 'Sin especialidad asignada' }}</p>
            </div>
        </div>

        {{-- Formulario --}}
        <form action="{{ route('medico.perfil.update') }}" method="POST" class="p-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nombres</label>
                    <input type="text" name="nombres"
                        value="{{ old('nombres', $medico->nombres) }}"
                        required
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Apellidos</label>
                    <input type="text" name="apellidos"
                        value="{{ old('apellidos', $medico->apellidos) }}"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">DNI</label>
                    <input type="text" name="dni"
                        value="{{ old('dni', $medico->dni) }}"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Teléfono</label>
                    <input type="text" name="telefono"
                        value="{{ old('telefono', $medico->telefono) }}"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">CMP</label>
                    <input type="text" name="cmp"
                        value="{{ old('cmp', $medico->cmp) }}"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Especialidad</label>
                    <input type="text"
                        value="{{ $medico->especialidad->nombre ?? 'No asignada' }}"
                        disabled
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50 text-gray-400 cursor-not-allowed">
                    <p class="text-xs text-gray-400 mt-1">Asignada por el administrador.</p>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Correo electrónico</label>
                    <input type="email"
                        value="{{ Auth::user()->email }}"
                        disabled
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50 text-gray-400 cursor-not-allowed">
                    <p class="text-xs text-gray-400 mt-1">El correo se gestiona desde administración.</p>
                </div>

            </div>

            {{-- Acciones --}}
            <div class="flex gap-3 mt-6 pt-5 border-t border-gray-100">
                <button type="submit"
                    class="bg-cyan-700 hover:bg-cyan-600 text-white font-semibold px-6 py-2.5 rounded-xl text-sm transition duration-200">
                    <i class="fa-solid fa-floppy-disk mr-2"></i>Guardar cambios
                </button>
                <a href="{{ route('medico.home') }}"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-6 py-2.5 rounded-xl text-sm transition duration-200">
                    Cancelar
                </a>
            </div>

        </form>
    </div>
</div>
@endsection