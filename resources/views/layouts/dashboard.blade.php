<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>{{ $titulo ?? 'Clínica D.S' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100 text-slate-950">

    <div class="min-h-screen flex">

        <aside class="w-64 bg-white border-r border-slate-200 flex flex-col fixed left-0 top-0 bottom-0">
            <div class="flex items-center gap-3 px-6 py-6">
                <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-700">
                    ♡
                </div>
                <h1 class="text-xl font-bold">Clínica D.S</h1>
            </div>

            <nav class="px-5 space-y-2 flex-1">

                @if(Auth::user()->tipo_usuario === 'administrador')
                <a href="{{ route('admin.home') }}" class="block rounded-2xl px-4 py-3 font-semibold {{ request()->routeIs('admin.home') ? 'bg-blue-50 text-blue-700' : 'hover:bg-slate-100' }}">
                    Dashboard Admin
                </a>

                <a href="{{ route('admin.usuarios.index') }}" class="block rounded-2xl px-4 py-3 font-semibold {{ request()->routeIs('admin.usuarios.*') ? 'bg-blue-50 text-blue-700' : 'hover:bg-slate-100' }}">
                    CRUD Usuarios
                </a>

                <a href="{{ route('admin.medicos.index') }}" class="block rounded-2xl px-4 py-3 font-semibold {{ request()->routeIs('admin.medicos.*') ? 'bg-blue-50 text-blue-700' : 'hover:bg-slate-100' }}">
                    CRUD Médicos
                </a>

                <a href="{{ route('admin.especialidades.index') }}" class="block rounded-2xl px-4 py-3 font-semibold {{ request()->routeIs('admin.especialidades.*') ? 'bg-blue-50 text-blue-700' : 'hover:bg-slate-100' }}">
                    CRUD Especialidades
                </a>

                <a href="{{ route('medico.horarios.index') }}"
                    class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-100 transition-colors">
                    <span>Gestión de horarios</span>
                </a>
                @endif

                @if(Auth::user()->tipo_usuario === 'medico')
                <a href="{{ route('medico.home') }}" class="block rounded-2xl px-4 py-3 font-semibold {{ request()->routeIs('medico.home') ? 'bg-blue-50 text-blue-700' : 'hover:bg-slate-100' }}">
                    Dashboard Médico
                </a>

                <a href="{{ route('medico.citas.index') }}" class="block rounded-2xl px-4 py-3 font-semibold {{ request()->routeIs('medico.citas.*') ? 'bg-blue-50 text-blue-700' : 'hover:bg-slate-100' }}">
                    Mis Citas
                </a>

                <a href="{{ route('medico.horarios.index') }}" class="block rounded-2xl px-4 py-3 font-semibold {{ request()->routeIs('medico.horarios.*') ? 'bg-blue-50 text-blue-700' : 'hover:bg-slate-100' }}">
                    Mis Horarios
                </a>

                <a href="{{ route('medico.perfil') }}" class="block rounded-2xl px-4 py-3 font-semibold {{ request()->routeIs('medico.perfil') ? 'bg-blue-50 text-blue-700' : 'hover:bg-slate-100' }}">
                    Mi Perfil
                </a>
                @endif

                @if(Auth::user()->tipo_usuario === 'paciente')
                <a href="{{ route('paciente.home') }}" class="block rounded-2xl px-4 py-3 font-semibold {{ request()->routeIs('paciente.home') ? 'bg-blue-50 text-blue-700' : 'hover:bg-slate-100' }}">
                    Inicio
                </a>

                <a href="{{ route('paciente.citas.index') }}" class="block rounded-2xl px-4 py-3 font-semibold {{ request()->routeIs('paciente.citas.*') ? 'bg-blue-50 text-blue-700' : 'hover:bg-slate-100' }}">
                    Mis Citas
                </a>

                <a href="{{ route('paciente.medicos.index') }}" class="block rounded-2xl px-4 py-3 font-semibold {{ request()->routeIs('paciente.medicos.*') ? 'bg-blue-50 text-blue-700' : 'hover:bg-slate-100' }}">
                    Médicos
                </a>

                <a href="{{ route('paciente.especialidades.index') }}" class="block rounded-2xl px-4 py-3 font-semibold {{ request()->routeIs('paciente.especialidades.*') ? 'bg-blue-50 text-blue-700' : 'hover:bg-slate-100' }}">
                    Especialidades
                </a>
                @endif

            </nav>

            <form action="{{ route('logout') }}" method="POST" class="p-5">
                @csrf
                <button class="w-full rounded-2xl bg-red-100 px-4 py-3 font-semibold text-red-700 hover:bg-red-200">
                    Cerrar sesión
                </button>
            </form>
        </aside>

        <div class="ml-64 flex-1 min-h-screen">
            <header class="bg-white border-b border-slate-200 px-8 py-5 flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold">{{ $titulo ?? 'Dashboard' }}</h1>
                    <p class="text-slate-500 mt-1">{{ $subtitulo ?? '' }}</p>
                </div>

                <div class="flex items-center gap-3">
                    <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center">
                        👤
                    </div>

                    <div>
                        <p class="font-bold capitalize">{{ Auth::user()->tipo_usuario }}</p>
                        <p class="text-sm text-slate-500">{{ Auth::user()->email }}</p>
                    </div>
                </div>
            </header>

            <main class="p-8">
                @yield('content')
            </main>
        </div>

    </div>

</body>

</html>