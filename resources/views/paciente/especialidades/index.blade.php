@extends('layouts.dashboard')

@section('titulo', 'Especialidades')
@section('header', 'Especialidades Disponibles')

@section('content')
<div class="space-y-5">

    <p class="text-sm text-gray-500">Conoce las especialidades médicas disponibles en Clínica DS.</p>

    <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-3">
        @forelse($especialidades as $especialidad)
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5 hover:border-cyan-400 hover:shadow-md transition duration-200">
            <div class="flex items-center gap-4 mb-3">
                <div class="w-11 h-11 rounded-xl bg-cyan-100 text-cyan-700 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-stethoscope text-lg"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900 text-sm">{{ $especialidad->nombre }}</h3>
                    <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 text-xs font-semibold px-2 py-0.5 rounded-full mt-1">
                        <i class="fa-solid fa-circle text-[7px]"></i> Disponible
                    </span>
                </div>
            </div>
            @if($especialidad->descripcion)
            <p class="text-sm text-gray-500 leading-relaxed">{{ $especialidad->descripcion }}</p>
            @endif
        </div>
        @empty
        <div class="md:col-span-2 lg:col-span-3 py-14 text-center">
            <div class="flex flex-col items-center gap-3 text-gray-400">
                <i class="fa-solid fa-stethoscope text-4xl"></i>
                <p class="text-sm font-medium">No hay especialidades disponibles por el momento.</p>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection