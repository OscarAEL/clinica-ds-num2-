@extends('layouts.dashboard', [
    'titulo' => 'Gestión de Usuarios',
    'subtitulo' => 'Administra los usuarios registrados en el sistema'
])

@section('content')

    @if (session('success'))
        <div class="mb-6 rounded-2xl bg-emerald-50 p-4 text-sm font-semibold text-emerald-700 ring-1 ring-emerald-100">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 rounded-2xl bg-red-50 p-4 text-sm font-semibold text-red-700 ring-1 ring-red-100">
            {{ session('error') }}
        </div>
    @endif

    <section class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">

        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-950">
                    Usuarios del sistema
                </h2>

                <p class="mt-2 text-slate-500">
                    Visualiza, edita o elimina usuarios registrados.
                </p>
            </div>

            <a href="{{ route('admin.home') }}"
               class="rounded-2xl bg-slate-100 px-5 py-3 text-center font-semibold text-slate-800 hover:bg-slate-200">
                Volver al panel
            </a>
        </div>

        <div class="overflow-hidden rounded-2xl ring-1 ring-slate-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-100">
                        <tr>
                            <th class="px-5 py-4 text-left text-sm font-bold text-slate-700">
                                Nombre
                            </th>

                            <th class="px-5 py-4 text-left text-sm font-bold text-slate-700">
                                Correo
                            </th>

                            <th class="px-5 py-4 text-left text-sm font-bold text-slate-700">
                                Tipo de usuario
                            </th>

                            <th class="px-5 py-4 text-right text-sm font-bold text-slate-700">
                                Acciones
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-200 bg-white">
                        @forelse ($usuarios as $usuario)
                            <tr class="hover:bg-slate-50">
                                <td class="px-5 py-5 font-semibold text-slate-950">
                                    {{ $usuario->name }}
                                </td>

                                <td class="px-5 py-5 text-sm text-slate-600">
                                    {{ $usuario->email }}
                                </td>

                                <td class="px-5 py-5">
                                    @if ($usuario->tipo_usuario === 'administrador')
                                        <span class="rounded-full bg-purple-50 px-3 py-1 text-xs font-semibold text-purple-700">
                                            Administrador
                                        </span>
                                    @elseif ($usuario->tipo_usuario === 'medico')
                                        <span class="rounded-full bg-cyan-50 px-3 py-1 text-xs font-semibold text-cyan-700">
                                            Médico
                                        </span>
                                    @else
                                        <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
                                            Paciente
                                        </span>
                                    @endif
                                </td>

                                <td class="px-5 py-5">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('admin.usuarios.edit', $usuario->id) }}"
                                           class="rounded-xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-200">
                                            Editar
                                        </a>

                                        @if ($usuario->id !== Auth::id())
                                            <form action="{{ route('admin.usuarios.destroy', $usuario->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('¿Seguro que deseas eliminar este usuario?')">
                                                @csrf
                                                @method('DELETE')

                                                <button class="rounded-xl bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700">
                                                    Eliminar
                                                </button>
                                            </form>
                                        @else
                                            <span class="rounded-xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-400">
                                                Protegido
                                            </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-10 text-center text-slate-500">
                                    No hay usuarios registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </section>

@endsection