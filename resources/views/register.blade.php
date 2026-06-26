<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Clínica D.S.</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="min-h-screen bg-gray-50 font-sans antialiased">

    <main class="flex min-h-screen items-center justify-center px-4 py-10">
        <div class="w-full max-w-lg">

            {{-- Logo --}}
            <div class="text-center mb-6">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-cyan-700 text-white text-2xl mb-3">
                    <i class="fa-solid fa-hospital-user"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-900">Clínica DS</h1>
                <p class="text-sm text-gray-500 mt-1">Crea tu cuenta como paciente</p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">

                <div class="bg-cyan-700 px-6 py-4">
                    <p class="text-white font-semibold">Datos personales</p>
                    <p class="text-cyan-200 text-xs mt-0.5">Completa el formulario para registrarte.</p>
                </div>

                @if($errors->any())
                <div class="mx-6 mt-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
                    @foreach($errors->all() as $error)
                    <p><i class="fa-solid fa-triangle-exclamation mr-2"></i>{{ $error }}</p>
                    @endforeach
                </div>
                @endif

                <form action="{{ route('registro.store') }}" method="POST" class="p-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nombres</label>
                            <input type="text" name="nombres" value="{{ old('nombres') }}" required
                                placeholder="Ej: Juan Carlos"
                                class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm
                                          focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Apellidos</label>
                            <input type="text" name="apellidos" value="{{ old('apellidos') }}" required
                                placeholder="Ej: García López"
                                class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm
                                          focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Teléfono</label>
                            <input type="text" name="telefono" value="{{ old('telefono') }}"
                                placeholder="Ej: 987654321"
                                class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm
                                          focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Correo electrónico</label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                placeholder="ejemplo@correo.com"
                                class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm
                                          focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Contraseña</label>
                            <input type="password" name="password" required
                                placeholder="Mínimo 6 caracteres"
                                class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm
                                          focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100">
                        </div>

                    </div>

                    <div class="mt-6 pt-5 border-t border-gray-100">
                        <button type="submit"
                            class="w-full bg-cyan-700 hover:bg-cyan-600 text-white font-semibold py-2.5 rounded-xl text-sm transition duration-200">
                            <i class="fa-solid fa-user-plus mr-2"></i>Crear cuenta
                        </button>
                    </div>

                </form>
            </div>

            <p class="text-center text-sm text-gray-500 mt-5">
                ¿Ya tienes cuenta?
                <a href="{{ route('login') }}" class="font-semibold text-cyan-700 hover:text-cyan-600">
                    Iniciar sesión
                </a>
            </p>
            <p class="text-center text-sm mt-2">
                <a href="{{ route('home') }}" class="text-gray-400 hover:text-gray-600">
                    Volver al inicio
                </a>
            </p>

        </div>
    </main>

</body>

</html>