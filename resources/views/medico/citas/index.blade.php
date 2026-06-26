@extends('layouts.dashboard')

@section('titulo', 'Citas Programadas')
@section('header', 'Citas Programadas')

@section('content')
<div class="space-y-5">

    <p class="text-sm text-gray-500">Gestiona las citas reservadas por tus pacientes.</p>

    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-xl text-sm font-medium">
        <i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}
    </div>
    @endif

    @forelse($citas as $cita)
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5">
        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">

            {{-- Datos de la cita --}}
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl bg-cyan-100 text-cyan-700 flex items-center justify-center font-bold text-lg flex-shrink-0">
                    {{ strtoupper(substr($cita->paciente->name ?? 'P', 0, 1)) }}
                </div>
                <div>
                    <p class="font-bold text-gray-900">{{ $cita->paciente->name ?? 'Paciente no encontrado' }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $cita->paciente->email ?? '—' }}</p>

                    <div class="mt-2 flex flex-wrap gap-3 text-xs text-gray-500">
                        <span>
                            <i class="fa-solid fa-calendar mr-1"></i>
                            {{ \Carbon\Carbon::parse($cita->fecha)->locale('es')->isoFormat('dddd D [de] MMMM [de] YYYY') }}
                        </span>
                        <span>
                            <i class="fa-solid fa-clock mr-1"></i>
                            {{ substr($cita->horario->hora_inicio, 0, 5) }} –
                            {{ substr($cita->horario->hora_fin, 0, 5) }}
                        </span>
                        @if($cita->horario->consultorio)
                        <span>
                            <i class="fa-solid fa-door-open mr-1"></i>
                            {{ $cita->horario->consultorio }}
                        </span>
                        @endif
                    </div>

                    @if($cita->motivo_consulta)
                    <p class="text-xs text-gray-500 mt-2 bg-gray-50 px-3 py-1.5 rounded-lg">
                        <i class="fa-solid fa-note-sticky mr-1 text-gray-400"></i>
                        {{ $cita->motivo_consulta }}
                    </p>
                    @endif

                    @if($cita->motivo_cancelacion)
                    <p class="text-xs text-red-500 mt-2">
                        <i class="fa-solid fa-triangle-exclamation mr-1"></i>
                        Motivo registrado: {{ $cita->motivo_cancelacion }}
                    </p>
                    @endif
                </div>
            </div>

            {{-- Estado + acciones --}}
            <div class="flex flex-col items-end gap-3 flex-shrink-0">

                {{-- Badge de estado --}}
                @if($cita->estado === 'reservada')
                <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 text-xs font-semibold px-3 py-1.5 rounded-full">
                    <i class="fa-solid fa-circle text-[7px]"></i> Reservada
                </span>
                @elseif($cita->estado === 'cancelada')
                <span class="inline-flex items-center gap-1.5 bg-red-50 text-red-600 text-xs font-semibold px-3 py-1.5 rounded-full">
                    <i class="fa-solid fa-circle text-[7px]"></i> Cancelada
                </span>
                @elseif($cita->estado === 'reprogramada')
                <span class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-700 text-xs font-semibold px-3 py-1.5 rounded-full">
                    <i class="fa-solid fa-circle text-[7px]"></i> Reprogramada
                </span>
                @endif

                {{-- Acciones solo si está reservada --}}
                @if($cita->estado === 'reservada')
                <div class="flex gap-2">
                    <button onclick="abrirModal('cancelar-{{ $cita->id }}')"
                        class="text-xs font-semibold px-3 py-1.5 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition duration-150">
                        <i class="fa-solid fa-xmark mr-1"></i>Cancelar
                    </button>
                    <button onclick="abrirModal('reprogramar-{{ $cita->id }}')"
                        class="text-xs font-semibold px-3 py-1.5 rounded-lg bg-amber-50 text-amber-700 hover:bg-amber-100 transition duration-150">
                        <i class="fa-solid fa-calendar-pen mr-1"></i>Reprogramar
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- MODAL: CANCELAR --}}
    <div id="modal-cancelar-{{ $cita->id }}"
        class="fixed inset-0 bg-black/40 z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-xl max-w-md w-full p-6">
            <h3 class="font-bold text-gray-900 text-lg mb-1">Cancelar cita</h3>
            <p class="text-sm text-gray-500 mb-4">
                Paciente: <strong>{{ $cita->paciente->name ?? '—' }}</strong> —
                {{ \Carbon\Carbon::parse($cita->fecha)->locale('es')->isoFormat('D [de] MMMM') }}
            </p>
            <form action="{{ route('medico.citas.cancelar', $cita) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Motivo de cancelación <span class="text-red-500">*</span>
                    </label>
                    <textarea name="motivo_cancelacion" rows="3" required
                        placeholder="Describe el motivo de la cancelación..."
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm resize-none
                                         focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100"></textarea>
                </div>
                <div class="flex gap-3 justify-end">
                    <button type="button" onclick="cerrarModal('cancelar-{{ $cita->id }}')"
                        class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-5 py-2 rounded-xl text-sm transition">
                        Volver
                    </button>
                    <button type="submit"
                        class="bg-red-600 hover:bg-red-500 text-white font-semibold px-5 py-2 rounded-xl text-sm transition">
                        <i class="fa-solid fa-xmark mr-1"></i>Confirmar cancelación
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL: REPROGRAMAR --}}
    <div id="modal-reprogramar-{{ $cita->id }}"
        class="fixed inset-0 bg-black/40 z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-xl max-w-md w-full p-6">
            <h3 class="font-bold text-gray-900 text-lg mb-1">Reprogramar cita</h3>
            <p class="text-sm text-gray-500 mb-4">
                Paciente: <strong>{{ $cita->paciente->name ?? '—' }}</strong> —
                Horario: {{ $cita->horario->dia_semana }}
                {{ substr($cita->horario->hora_inicio, 0, 5) }}–{{ substr($cita->horario->hora_fin, 0, 5) }}
            </p>
            <form action="{{ route('medico.citas.reprogramar', $cita) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Nueva fecha <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="nueva_fecha" required
                        min="{{ date('Y-m-d') }}"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm
                                      focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100">
                    <p class="text-xs text-gray-400 mt-1">
                        Este médico atiende los <strong>{{ $cita->horario->dia_semana }}</strong>.
                    </p>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Motivo de reprogramación <span class="text-red-500">*</span>
                    </label>
                    <textarea name="motivo_cancelacion" rows="3" required
                        placeholder="Explica por qué se reprograma la cita..."
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm resize-none
                                         focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100"></textarea>
                </div>
                <div class="flex gap-3 justify-end">
                    <button type="button" onclick="cerrarModal('reprogramar-{{ $cita->id }}')"
                        class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-5 py-2 rounded-xl text-sm transition">
                        Volver
                    </button>
                    <button type="submit"
                        class="bg-amber-600 hover:bg-amber-500 text-white font-semibold px-5 py-2 rounded-xl text-sm transition">
                        <i class="fa-solid fa-calendar-pen mr-1"></i>Confirmar reprogramación
                    </button>
                </div>
            </form>
        </div>
    </div>

    @empty
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm py-16 text-center">
        <div class="flex flex-col items-center gap-3 text-gray-400">
            <i class="fa-solid fa-calendar-check text-5xl"></i>
            <p class="font-medium text-gray-500">Aún no tienes citas reservadas por pacientes.</p>
        </div>
    </div>
    @endforelse

</div>

<script>
    function abrirModal(id) {
        const modal = document.getElementById('modal-' + id);
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function cerrarModal(id) {
        const modal = document.getElementById('modal-' + id);
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
    // Cerrar modal al hacer clic en el fondo
    document.querySelectorAll('[id^="modal-"]').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) cerrarModal(this.id.replace('modal-', ''));
        });
    });
</script>
@endsection