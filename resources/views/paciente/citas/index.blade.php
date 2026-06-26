@extends('layouts.dashboard')

@section('titulo', 'Reservar Cita')
@section('header', 'Reservar Cita Médica')

@section('content')
<div class="max-w-3xl mx-auto space-y-5">

    {{-- Mensaje de éxito --}}
    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-xl text-sm font-medium">
        <i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}
    </div>
    @endif

    {{-- Errores del servidor --}}
    @if($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-xl text-sm">
        @foreach($errors->all() as $error)
        <p><i class="fa-solid fa-triangle-exclamation mr-2"></i>{{ $error }}</p>
        @endforeach
    </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">

        {{-- Indicador de pasos --}}
        <div class="bg-cyan-700 px-6 py-5">
            <p class="text-cyan-100 text-xs font-medium uppercase tracking-wider mb-4">Proceso de reserva guiada</p>
            <div class="flex items-center">
                @foreach([1 => 'Especialidad', 2 => 'Médico', 3 => 'Horario', 4 => 'Fecha', 5 => 'Confirmar'] as $n => $label)
                <div class="flex flex-col items-center gap-1.5 flex-shrink-0">
                    <div id="step-badge-{{ $n }}"
                        class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold transition-all duration-200
                                    {{ $n === 1 ? 'bg-white text-cyan-700' : 'bg-white/20 text-white' }}">
                        {{ $n }}
                    </div>
                    <span id="step-label-{{ $n }}"
                        class="text-xs font-medium text-center transition-all duration-200
                                     {{ $n === 1 ? 'text-white' : 'text-cyan-300' }}">
                        {{ $label }}
                    </span>
                </div>
                @if($n < 5)
                    <div id="step-line-{{ $n }}"
                    class="h-0.5 flex-1 mx-2 mb-5 transition-all duration-200 bg-white/20">
            </div>
            @endif
            @endforeach
        </div>
    </div>

    <form action="{{ route('paciente.citas.store') }}" method="POST" id="wizard-form">
        @csrf
        <input type="hidden" name="horario_id" id="input-horario-id">
        <input type="hidden" name="fecha" id="input-fecha">

        <div class="p-6">

            {{-- ========== PASO 1: ESPECIALIDAD ========== --}}
            <div id="step-1" class="space-y-4">
                <p class="text-sm text-gray-500">Selecciona la especialidad médica que necesitas.</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @forelse($especialidades as $esp)
                    <button type="button"
                        onclick="selectEspecialidad({{ $esp->id }}, '{{ addslashes($esp->nombre) }}')"
                        id="card-esp-{{ $esp->id }}"
                        class="especialidad-card text-left p-4 rounded-xl border-2 border-gray-200 hover:border-cyan-400 hover:bg-cyan-50/50 transition duration-200">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-cyan-100 text-cyan-700 flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-stethoscope text-sm"></i>
                            </div>
                            <span class="font-semibold text-gray-800 text-sm">{{ $esp->nombre }}</span>
                        </div>
                    </button>
                    @empty
                    <div class="col-span-2 py-10 text-center text-gray-400">
                        <i class="fa-solid fa-stethoscope text-3xl mb-2 block"></i>
                        <p class="text-sm">No hay especialidades disponibles.</p>
                    </div>
                    @endforelse
                </div>

                <div class="flex justify-end pt-2">
                    <button type="button" onclick="goToStep(2)" id="btn-step1-next" disabled
                        class="bg-cyan-700 hover:bg-cyan-600 disabled:opacity-40 disabled:cursor-not-allowed
                                       text-white font-semibold px-6 py-2.5 rounded-xl text-sm transition duration-200">
                        Siguiente <i class="fa-solid fa-arrow-right ml-1"></i>
                    </button>
                </div>
            </div>

            {{-- ========== PASO 2: MÉDICO ========== --}}
            <div id="step-2" class="space-y-4 hidden">
                <div class="flex items-center gap-2 text-sm">
                    <span class="text-gray-400">Especialidad:</span>
                    <span id="resumen-especialidad" class="font-semibold text-cyan-700"></span>
                </div>
                <p class="text-sm text-gray-500">Elige al médico de tu preferencia.</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3" id="medicos-grid"></div>

                <div class="flex justify-between pt-2">
                    <button type="button" onclick="goToStep(1)"
                        class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-6 py-2.5 rounded-xl text-sm transition duration-200">
                        <i class="fa-solid fa-arrow-left mr-1"></i> Atrás
                    </button>
                    <button type="button" onclick="goToStep(3)" id="btn-step2-next" disabled
                        class="bg-cyan-700 hover:bg-cyan-600 disabled:opacity-40 disabled:cursor-not-allowed
                                       text-white font-semibold px-6 py-2.5 rounded-xl text-sm transition duration-200">
                        Siguiente <i class="fa-solid fa-arrow-right ml-1"></i>
                    </button>
                </div>
            </div>

            {{-- ========== PASO 3: HORARIO ========== --}}
            <div id="step-3" class="space-y-4 hidden">
                <div class="flex items-center gap-2 text-sm">
                    <span class="text-gray-400">Médico:</span>
                    <span id="resumen-medico" class="font-semibold text-cyan-700"></span>
                </div>
                <p class="text-sm text-gray-500">Selecciona un bloque de horario disponible.</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3" id="horarios-grid"></div>

                <div class="flex justify-between pt-2">
                    <button type="button" onclick="goToStep(2)"
                        class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-6 py-2.5 rounded-xl text-sm transition duration-200">
                        <i class="fa-solid fa-arrow-left mr-1"></i> Atrás
                    </button>
                    <button type="button" onclick="goToStep(4)" id="btn-step3-next" disabled
                        class="bg-cyan-700 hover:bg-cyan-600 disabled:opacity-40 disabled:cursor-not-allowed
                                       text-white font-semibold px-6 py-2.5 rounded-xl text-sm transition duration-200">
                        Siguiente <i class="fa-solid fa-arrow-right ml-1"></i>
                    </button>
                </div>
            </div>

            {{-- ========== PASO 4: FECHA ========== --}}
            <div id="step-4" class="space-y-4 hidden">
                <div class="flex items-center gap-2 text-sm">
                    <span class="text-gray-400">Horario:</span>
                    <span id="resumen-horario" class="font-semibold text-cyan-700"></span>
                </div>

                <p class="text-sm text-gray-500">Selecciona una de las próximas fechas disponibles.</p>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3" id="fechas-grid"></div>

                <p id="fechas-agotadas" class="hidden text-sm text-amber-700 bg-amber-50 border border-amber-200 px-4 py-3 rounded-xl">
                    <i class="fa-solid fa-triangle-exclamation mr-2"></i>
                    Todas las fechas próximas están ocupadas. Intenta con otro horario.
                </p>

                <div class="flex justify-between pt-2">
                    <button type="button" onclick="goToStep(3)"
                        class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-6 py-2.5 rounded-xl text-sm transition duration-200">
                        <i class="fa-solid fa-arrow-left mr-1"></i> Atrás
                    </button>
                    <button type="button" onclick="goToStep(5)" id="btn-step4-next" disabled
                        class="bg-cyan-700 hover:bg-cyan-600 disabled:opacity-40 disabled:cursor-not-allowed
                       text-white font-semibold px-6 py-2.5 rounded-xl text-sm transition duration-200">
                        Siguiente <i class="fa-solid fa-arrow-right ml-1"></i>
                    </button>
                </div>
            </div>

            {{-- ========== PASO 5: CONFIRMACIÓN ========== --}}
            <div id="step-5" class="space-y-5 hidden">
                <p class="text-sm text-gray-500">Revisa el resumen antes de confirmar tu reserva.</p>

                <div class="bg-gray-50 rounded-xl border border-gray-200 divide-y divide-gray-200">
                    <div class="flex items-center gap-3 p-4">
                        <div class="w-8 h-8 rounded-lg bg-cyan-100 text-cyan-700 flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-stethoscope text-xs"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide font-medium">Especialidad</p>
                            <p id="confirm-especialidad" class="text-sm font-bold text-gray-800"></p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 p-4">
                        <div class="w-8 h-8 rounded-lg bg-purple-100 text-purple-700 flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-user-doctor text-xs"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide font-medium">Médico</p>
                            <p id="confirm-medico" class="text-sm font-bold text-gray-800"></p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 p-4">
                        <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-clock text-xs"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide font-medium">Horario</p>
                            <p id="confirm-horario" class="text-sm font-bold text-gray-800"></p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 p-4">
                        <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-calendar text-xs"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide font-medium">Fecha</p>
                            <p id="confirm-fecha" class="text-sm font-bold text-gray-800"></p>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Motivo de consulta
                        <span class="text-gray-400 font-normal">(opcional)</span>
                    </label>
                    <textarea name="motivo_consulta" rows="3"
                        placeholder="Describe brevemente el motivo de tu consulta..."
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm resize-none
                                         focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100"></textarea>
                </div>

                <div class="flex justify-between pt-2">
                    <button type="button" onclick="goToStep(4)"
                        class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-6 py-2.5 rounded-xl text-sm transition duration-200">
                        <i class="fa-solid fa-arrow-left mr-1"></i> Atrás
                    </button>
                    <button type="submit"
                        class="bg-emerald-600 hover:bg-emerald-500 text-white font-bold px-8 py-2.5 rounded-xl text-sm transition duration-200 shadow-sm">
                        <i class="fa-solid fa-calendar-check mr-2"></i>Confirmar Reserva
                    </button>
                </div>
            </div>

        </div>
    </form>
</div>
</div>

<script>
    const allMedicos = @json($medicos);
    const allHorarios = @json($horarios);
    const citasReservadas = @json($citasReservadas);

    const state = {
        especialidadId: null,
        especialidadNombre: null,
        medicoId: null,
        medicoNombre: null,
        horarioId: null,
        horarioDia: null,
        horarioTexto: null,
        fecha: null,
    };

    const diasMap = {
        'Domingo': 0,
        'Lunes': 1,
        'Martes': 2,
        'Miércoles': 3,
        'Jueves': 4,
        'Viernes': 5,
        'Sábado': 6
    };

    const meses = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio',
        'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'
    ];

    // ===== NAVEGACIÓN =====
    function goToStep(n) {
        if (n === 2 && !state.especialidadId) return;
        if (n === 3 && !state.medicoId) return;
        if (n === 4 && !state.horarioId) return;
        if (n === 5 && !state.fecha) return;

        [1, 2, 3, 4, 5].forEach(i =>
            document.getElementById('step-' + i).classList.add('hidden')
        );
        document.getElementById('step-' + n).classList.remove('hidden');
        updateStepIndicator(n);

        if (n === 2) renderMedicos();
        if (n === 3) renderHorarios();
        if (n === 4) renderFechas();
        if (n === 5) updateSummary();
    }

    function updateStepIndicator(current) {
        [1, 2, 3, 4, 5].forEach(i => {
            const badge = document.getElementById('step-badge-' + i);
            const label = document.getElementById('step-label-' + i);
            const line = document.getElementById('step-line-' + i);

            if (i < current) {
                badge.className = 'w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold transition-all duration-200 bg-white text-cyan-700';
                badge.innerHTML = '<i class="fa-solid fa-check text-xs"></i>';
                label.className = 'text-xs font-medium text-center transition-all duration-200 text-white';
                if (line) line.className = 'h-0.5 flex-1 mx-2 mb-5 transition-all duration-200 bg-white';
            } else if (i === current) {
                badge.className = 'w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold transition-all duration-200 bg-white text-cyan-700';
                badge.innerHTML = i;
                label.className = 'text-xs font-medium text-center transition-all duration-200 text-white';
                if (line) line.className = 'h-0.5 flex-1 mx-2 mb-5 transition-all duration-200 bg-white/20';
            } else {
                badge.className = 'w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold transition-all duration-200 bg-white/20 text-white';
                badge.innerHTML = i;
                label.className = 'text-xs font-medium text-center transition-all duration-200 text-cyan-300';
                if (line) line.className = 'h-0.5 flex-1 mx-2 mb-5 transition-all duration-200 bg-white/20';
            }
        });
    }

    // ===== PASO 1: ESPECIALIDAD =====
    function selectEspecialidad(id, nombre) {
        state.especialidadId = id;
        state.especialidadNombre = nombre;
        state.medicoId = null;
        state.horarioId = null;
        state.fecha = null;

        document.querySelectorAll('.especialidad-card').forEach(card => {
            card.classList.remove('border-cyan-500', 'bg-cyan-50');
            card.classList.add('border-gray-200');
        });
        const card = document.getElementById('card-esp-' + id);
        card.classList.replace('border-gray-200', 'border-cyan-500');
        card.classList.add('bg-cyan-50');
        document.getElementById('btn-step1-next').disabled = false;
    }

    // ===== PASO 2: MÉDICO =====
    function renderMedicos() {
        const grid = document.getElementById('medicos-grid');
        document.getElementById('resumen-especialidad').textContent = state.especialidadNombre;

        const filtered = allMedicos.filter(m => m.especialidad_id === state.especialidadId);

        if (filtered.length === 0) {
            grid.innerHTML = `<div class="col-span-2 py-10 text-center text-gray-400">
            <i class="fa-solid fa-user-doctor text-3xl mb-2 block"></i>
            <p class="text-sm">No hay médicos disponibles para esta especialidad.</p>
        </div>`;
            document.getElementById('btn-step2-next').disabled = true;
            return;
        }

        grid.innerHTML = filtered.map(m => `
        <button type="button"
                onclick="selectMedico(${m.id}, 'Dr. ${m.nombres} ${m.apellidos}')"
                id="card-med-${m.id}"
                class="medico-card text-left p-4 rounded-xl border-2 border-gray-200
                       hover:border-cyan-400 hover:bg-cyan-50/50 transition duration-200">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-cyan-100 text-cyan-700 flex items-center justify-center font-bold text-sm flex-shrink-0">
                    ${m.nombres.charAt(0).toUpperCase()}
                </div>
                <div>
                    <p class="font-semibold text-gray-800 text-sm">Dr. ${m.nombres} ${m.apellidos}</p>
                    <p class="text-xs text-gray-400">${m.especialidad ? m.especialidad.nombre : ''}</p>
                </div>
            </div>
        </button>
    `).join('');
    }

    function selectMedico(id, nombre) {
        state.medicoId = id;
        state.medicoNombre = nombre;
        state.horarioId = null;
        state.fecha = null;

        document.querySelectorAll('.medico-card').forEach(card => {
            card.classList.remove('border-cyan-500', 'bg-cyan-50');
            card.classList.add('border-gray-200');
        });
        const card = document.getElementById('card-med-' + id);
        if (card) {
            card.classList.replace('border-gray-200', 'border-cyan-500');
            card.classList.add('bg-cyan-50');
        }
        document.getElementById('btn-step2-next').disabled = false;
    }

    // ===== PASO 3: HORARIO =====
    function renderHorarios() {
        const grid = document.getElementById('horarios-grid');
        document.getElementById('resumen-medico').textContent = state.medicoNombre;

        const filtered = allHorarios.filter(h => h.medico_id === state.medicoId);

        if (filtered.length === 0) {
            grid.innerHTML = `<div class="col-span-2 py-10 text-center text-gray-400">
            <i class="fa-solid fa-clock text-3xl mb-2 block"></i>
            <p class="text-sm">Este médico no tiene horarios disponibles aún.</p>
        </div>`;
            document.getElementById('btn-step3-next').disabled = true;
            return;
        }

        grid.innerHTML = filtered.map(h => {
            const inicio = h.hora_inicio.substring(0, 5);
            const fin = h.hora_fin.substring(0, 5);
            return `
        <button type="button"
                onclick="selectHorario(${h.id}, '${h.dia_semana}', '${h.dia_semana} ${inicio}–${fin}')"
                id="card-hor-${h.id}"
                class="horario-card text-left p-4 rounded-xl border-2 border-gray-200
                       hover:border-cyan-400 hover:bg-cyan-50/50 transition duration-200">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-clock text-sm"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-800 text-sm">${h.dia_semana}</p>
                    <p class="text-xs text-gray-500">${inicio} – ${fin}</p>
                    ${h.consultorio ? `<p class="text-xs text-gray-400">${h.consultorio}</p>` : ''}
                </div>
            </div>
        </button>`;
        }).join('');
    }

    function selectHorario(id, dia, texto) {
        state.horarioId = id;
        state.horarioDia = dia;
        state.horarioTexto = texto;
        state.fecha = null;

        document.querySelectorAll('.horario-card').forEach(card => {
            card.classList.remove('border-cyan-500', 'bg-cyan-50');
            card.classList.add('border-gray-200');
        });
        const card = document.getElementById('card-hor-' + id);
        if (card) {
            card.classList.replace('border-gray-200', 'border-cyan-500');
            card.classList.add('bg-cyan-50');
        }
        document.getElementById('btn-step3-next').disabled = false;
    }

    // ===== PASO 4: FECHAS DISPONIBLES =====
    function getProximasFechas(diaSemana, cantidad) {
        const target = diasMap[diaSemana];
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        const fechas = [];
        let current = new Date(today);

        // Buscar el primer día válido (mínimo mañana)
        current.setDate(current.getDate() + 1);

        while (fechas.length < cantidad) {
            if (current.getDay() === target) {
                fechas.push(new Date(current));
            }
            current.setDate(current.getDate() + 1);
        }
        return fechas;
    }

    function formatDateStr(date) {
        return date.toISOString().split('T')[0];
    }

    function formatDateLabel(date) {
        const dias = ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'];
        return `${dias[date.getDay()]} ${date.getDate()} de ${meses[date.getMonth()]}`;
    }

    function renderFechas() {
        const grid = document.getElementById('fechas-grid');
        const agotadas = document.getElementById('fechas-agotadas');
        document.getElementById('resumen-horario').textContent = state.horarioTexto;
        document.getElementById('btn-step4-next').disabled = true;
        state.fecha = null;

        const fechas = getProximasFechas(state.horarioDia, 8);
        const ocupadas = citasReservadas[state.horarioId] || [];

        const disponibles = fechas.filter(f => !ocupadas.includes(formatDateStr(f)));

        if (disponibles.length === 0) {
            grid.innerHTML = '';
            agotadas.classList.remove('hidden');
            return;
        }

        agotadas.classList.add('hidden');

        // Mostrar máximo 4 fechas disponibles
        const mostrar = disponibles.slice(0, 4);

        grid.innerHTML = mostrar.map(f => {
            const dateStr = formatDateStr(f);
            return `
        <button type="button"
                onclick="selectFecha('${dateStr}', this)"
                class="fecha-card p-4 rounded-xl border-2 border-gray-200 text-center
                       hover:border-cyan-400 hover:bg-cyan-50/50 transition duration-200">
            <p class="text-xs text-gray-400 font-medium">${state.horarioDia}</p>
            <p class="font-bold text-gray-800 text-sm mt-1">${f.getDate()} de ${meses[f.getMonth()]}</p>
            <p class="text-xs text-gray-500">${f.getFullYear()}</p>
        </button>`;
        }).join('');
    }

    function selectFecha(dateStr, btn) {
        state.fecha = dateStr;
        document.getElementById('input-fecha').value = dateStr;
        document.getElementById('input-horario-id').value = state.horarioId;

        document.querySelectorAll('.fecha-card').forEach(card => {
            card.classList.remove('border-cyan-500', 'bg-cyan-50');
            card.classList.add('border-gray-200');
        });
        btn.classList.replace('border-gray-200', 'border-cyan-500');
        btn.classList.add('bg-cyan-50');
        document.getElementById('btn-step4-next').disabled = false;
    }

    // ===== PASO 5: RESUMEN =====
    function formatDateFull(str) {
        const [y, m, d] = str.split('-');
        return `${parseInt(d)} de ${meses[parseInt(m)-1]} de ${y}`;
    }

    function updateSummary() {
        document.getElementById('confirm-especialidad').textContent = state.especialidadNombre;
        document.getElementById('confirm-medico').textContent = state.medicoNombre;
        document.getElementById('confirm-horario').textContent = state.horarioTexto;
        document.getElementById('confirm-fecha').textContent = formatDateFull(state.fecha);
        document.getElementById('input-horario-id').value = state.horarioId;
        document.getElementById('input-fecha').value = state.fecha;
    }
</script>
@endsection