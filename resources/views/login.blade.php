<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión - Clínica D.S.</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-50 text-slate-900">

    <main class="flex min-h-screen items-center justify-center px-4 py-8">
        <section class="w-full max-w-md rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">

            <div class="mb-6 text-center">
                <h1 class="text-2xl font-bold text-slate-950">
                    Iniciar sesión
                </h1>
                <p class="mt-2 text-sm text-slate-600">
                    Ingresa con tu correo y contraseña.
                </p>
            </div>

            @if ($errors->any())
                <div class="mb-4 rounded-2xl bg-red-50 p-4 text-sm text-red-700">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('login.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">
                        Correo electrónico
                    </label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        class="w-full rounded-2xl border border-slate-300 px-4 py-3 outline-none focus:border-cyan-600 focus:ring-4 focus:ring-cyan-100"
                        placeholder="ejemplo@correo.com"
                    >
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">
                        Contraseña
                    </label>
                    <input
                        type="password"
                        name="password"
                        required
                        class="w-full rounded-2xl border border-slate-300 px-4 py-3 outline-none focus:border-cyan-600 focus:ring-4 focus:ring-cyan-100"
                        placeholder="Tu contraseña"
                    >
                </div>

                <button
                    type="submit"
                    class="w-full rounded-2xl bg-cyan-600 px-6 py-3 font-semibold text-white transition hover:bg-cyan-700">
                    Ingresar
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-slate-600">
                ¿No tienes cuenta?
                <a href="{{ route('registro') }}" class="font-semibold text-cyan-700 hover:text-cyan-800">
                    Registrarse
                </a>
            </p>

            <p class="mt-3 text-center text-sm">
                <a href="{{ route('home') }}" class="text-slate-500 hover:text-slate-700">
                    Volver al inicio
                </a>
            </p>

        </section>
    </main>

</body>
</html>