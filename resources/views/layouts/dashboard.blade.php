<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'Panel') - Clínica DS</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100 font-sans antialiased">

    <div class="flex h-screen overflow-hidden">

        {{-- ===== SIDEBAR ===== --}}
        <aside class="w-64 bg-cyan-700 text-white flex flex-col justify-between shadow-lg z-10 flex-shrink-0">

            {{-- Logo --}}
            <div>
                <div class="p-5 text-center border-b border-blue-800">
                    <h1 class="text-xl font-bold tracking-wider">
                        <i class="fa-solid fa-hospital-user mr-2"></i>Clínica DS
                    </h1>
                    <span class="text-xs text-blue-300 block mt-1">Panel de Control</span>
                </div>

                <nav class="mt-6 px-4 space-y-1">

                    {{-- ==============================
                     MENÚ: ADMINISTRADOR
                ================================= --}}
                    @if(auth()->user()->tipo_usuario == 'administrador')

                    <p class="text-[10px] text-cyan-400 uppercase tracking-widest px-3 pt-2 pb-1">General</p>

                    <a href="{{ route('admin.home') }}"
                        class="flex items-center p-3 rounded-lg hover:bg-cyan-600 transition duration-200
                              {{ request()->routeIs('admin.home') ? 'bg-cyan-600 font-semibold' : '' }}">
                        <i class="fa-solid fa-chart-line w-8"></i> Dashboard
                    </a>

                    <p class="text-[10px] text-cyan-400 uppercase tracking-widest px-3 pt-3 pb-1">Gestión</p>

                    <a href="{{ route('admin.usuarios.index') }}"
                        class="flex items-center p-3 rounded-lg hover:bg-cyan-600 transition duration-200
                              {{ request()->routeIs('admin.usuarios.*') ? 'bg-cyan-600 font-semibold' : '' }}">
                        <i class="fa-solid fa-users w-8"></i> Usuarios
                    </a>

                    <a href="{{ route('admin.medicos.index') }}"
                        class="flex items-center p-3 rounded-lg hover:bg-cyan-600 transition duration-200
                              {{ request()->routeIs('admin.medicos.*') ? 'bg-cyan-600 font-semibold' : '' }}">
                        <i class="fa-solid fa-user-doctor w-8"></i> Médicos
                    </a>

                    <a href="{{ route('admin.especialidades.index') }}"
                        class="flex items-center p-3 rounded-lg hover:bg-cyan-600 transition duration-200
                              {{ request()->routeIs('admin.especialidades.*') ? 'bg-cyan-600 font-semibold' : '' }}">
                        <i class="fa-solid fa-stethoscope w-8"></i> Especialidades
                    </a>

                    <a href="{{ route('medico.horarios.index') }}"
                        class="flex items-center p-3 rounded-lg hover:bg-cyan-600 transition duration-200
                              {{ request()->routeIs('medico.horarios.*') ? 'bg-cyan-600 font-semibold' : '' }}">
                        <i class="fa-solid fa-clock w-8"></i> Horarios
                    </a>

                    {{-- ==============================
                     MENÚ: MÉDICO
                    ================================= --}}
                    @elseif(auth()->user()->tipo_usuario == 'medico')

                    <p class="text-[10px] text-cyan-400 uppercase tracking-widest px-3 pt-2 pb-1">General</p>

                    <a href="{{ route('medico.home') }}"
                        class="flex items-center p-3 rounded-lg hover:bg-cyan-600 transition duration-200
                              {{ request()->routeIs('medico.home') ? 'bg-cyan-600 font-semibold' : '' }}">
                        <i class="fa-solid fa-house-medical w-8"></i> Inicio
                    </a>

                    <p class="text-[10px] text-cyan-400 uppercase tracking-widest px-3 pt-3 pb-1">Citas</p>

                    <a href="{{ route('medico.citas.index') }}"
                        class="flex items-center p-3 rounded-lg hover:bg-cyan-600 transition duration-200
                              {{ request()->routeIs('medico.citas.*') ? 'bg-cyan-600 font-semibold' : '' }}">
                        <i class="fa-solid fa-calendar-check w-8"></i> Mis Citas
                    </a>

                    <p class="text-[10px] text-cyan-400 uppercase tracking-widest px-3 pt-3 pb-1">Disponibilidad</p>

                    <a href="{{ route('medico.horarios.index') }}"
                        class="flex items-center p-3 rounded-lg hover:bg-cyan-600 transition duration-200
                              {{ request()->routeIs('medico.horarios.*') ? 'bg-cyan-600 font-semibold' : '' }}">
                        <i class="fa-solid fa-clock w-8"></i> Mis Horarios
                    </a>

                    <p class="text-[10px] text-cyan-400 uppercase tracking-widest px-3 pt-3 pb-1">Cuenta</p>

                    <a href="{{ route('medico.perfil') }}"
                        class="flex items-center p-3 rounded-lg hover:bg-cyan-600 transition duration-200
                              {{ request()->routeIs('medico.perfil') ? 'bg-cyan-600 font-semibold' : '' }}">
                        <i class="fa-solid fa-user-gear w-8"></i> Mi Perfil
                    </a>

                    {{-- ==============================
                     MENÚ: PACIENTE
                ================================= --}}
                    @else

                    <p class="text-[10px] text-cyan-400 uppercase tracking-widest px-3 pt-2 pb-1">General</p>

                    <a href="{{ route('paciente.home') }}"
                        class="flex items-center p-3 rounded-lg hover:bg-cyan-600 transition duration-200
                              {{ request()->routeIs('paciente.home') ? 'bg-cyan-600 font-semibold' : '' }}">
                        <i class="fa-solid fa-house w-8"></i> Inicio
                    </a>

                    <p class="text-[10px] text-cyan-400 uppercase tracking-widest px-3 pt-3 pb-1">Citas</p>

                    <a href="{{ route('paciente.citas.index') }}"
                        class="flex items-center p-3 rounded-lg hover:bg-cyan-600 transition duration-200
                              {{ request()->routeIs('paciente.citas.*') ? 'bg-cyan-600 font-semibold' : '' }}">
                        <i class="fa-solid fa-calendar-plus w-8"></i> Reservar Cita
                    </a>

                    <a href="{{ route('paciente.mis-citas.index') }}"
                        class="flex items-center p-3 rounded-lg hover:bg-cyan-600 transition duration-200
                                {{ request()->routeIs('paciente.mis-citas.*') ? 'bg-cyan-600 font-semibold' : '' }}">
                        <i class="fa-solid fa-calendar-check w-8"></i> Mis Citas
                    </a>

                    <p class="text-[10px] text-cyan-400 uppercase tracking-widest px-3 pt-3 pb-1">Explorar</p>

                    <a href="{{ route('paciente.especialidades.index') }}"
                        class="flex items-center p-3 rounded-lg hover:bg-cyan-600 transition duration-200
                              {{ request()->routeIs('paciente.especialidades.*') ? 'bg-cyan-600 font-semibold' : '' }}">
                        <i class="fa-solid fa-stethoscope w-8"></i> Especialidades
                    </a>

                    <a href="{{ route('paciente.medicos.index') }}"
                        class="flex items-center p-3 rounded-lg hover:bg-cyan-600 transition duration-200
                              {{ request()->routeIs('paciente.medicos.*') ? 'bg-cyan-600 font-semibold' : '' }}">
                        <i class="fa-solid fa-user-doctor w-8"></i> Médicos
                    </a>

                    <p class="text-[10px] text-cyan-400 uppercase tracking-widest px-3 pt-3 pb-1">Cuenta</p>

                    @endif

                </nav>
            </div>

            {{-- Footer sidebar --}}
            <div class="p-4 border-t border-blue-800 bg-cyan-900">
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-8 h-8 rounded-full bg-cyan-500 flex items-center justify-center text-sm font-bold flex-shrink-0">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-sm font-medium truncate">{{ auth()->user()->name }}</p>
                        <span class="text-[10px] text-cyan-300 uppercase tracking-wide">
                            {{ auth()->user()->tipo_usuario }}
                        </span>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-center p-2 bg-red-600 hover:bg-red-700 rounded-lg text-sm font-medium transition duration-200">
                        <i class="fa-solid fa-right-from-bracket mr-2"></i> Cerrar Sesión
                    </button>
                </form>
            </div>

        </aside>

        {{-- ===== CONTENIDO PRINCIPAL ===== --}}
        <main class="flex-1 flex flex-col h-full overflow-y-auto bg-gray-50">

            <header class="bg-white border-b border-gray-200 px-8 py-4 flex justify-between items-center flex-shrink-0">
                <h2 class="text-lg font-semibold text-gray-700">
                    @yield('header', 'Panel de Control')
                </h2>
                <div class="text-sm text-gray-400">
                    <i class="fa-regular fa-calendar mr-1"></i>{{ date('d/m/Y') }}
                </div>
            </header>

            <div class="p-8 flex-1">
                @yield('content')
            </div>

        </main>

    </div>

</body>

</html>