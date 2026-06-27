<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clínica D.S.</title>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-slate-50 text-slate-900">

    <main class="min-h-screen bg-slate-50">

        {{-- NAVBAR --}}
        <header class="sticky top-0 z-50 border-b border-slate-200 bg-white/90 backdrop-blur">
            <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">

                <a href="{{ route('home') }}">
                    <div>
                        <h1 class="text-xl font-bold text-slate-950">
                            Clínica D.S.
                        </h1>
                        <p class="text-xs text-slate-500">
                            Salud y atención médica
                        </p>
                    </div>
                </a>

                <nav class="hidden items-center gap-6 text-sm font-medium text-slate-600 md:flex">
                    <a href="#inicio" class="hover:text-cyan-700">Inicio</a>
                    <a href="#contacto" class="hover:text-cyan-700">Contacto</a>
                </nav>

                <div class="flex items-center gap-2">
                    <a href="{{ route('login') }}"
                        class="rounded-xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-800 transition hover:bg-slate-200">
                        Iniciar sesión
                    </a>

                    <a href="{{ route('registro') }}"
                        class="rounded-xl bg-cyan-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-cyan-700">
                        Registrarse
                    </a>
                </div>

            </div>
        </header>

        <div class="mx-auto flex w-full max-w-7xl flex-col gap-8 px-4 py-6 sm:px-6 lg:px-8">

            {{-- HERO PRINCIPAL --}}
            <section id="inicio" class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-slate-200">
                <div class="grid items-center gap-8 p-6 md:p-8 lg:grid-cols-2 lg:p-10">

                    <div class="space-y-6">
                        <div class="inline-flex items-center gap-2 rounded-full bg-cyan-50 px-4 py-2 text-sm font-semibold text-cyan-700 ring-1 ring-cyan-100">
                            <span>🩺</span>
                            <span>Atención médica confiable</span>
                        </div>

                        <div class="space-y-4">
                            <h2 class="text-3xl font-bold tracking-tight text-slate-950 sm:text-4xl lg:text-5xl">
                                Cuidamos tu salud con atención clara, rápida y humana
                            </h2>

                            <p class="max-w-2xl text-base leading-8 text-slate-600 sm:text-lg">
                                En Clínica D.S. trabajamos para brindar una atención médica cercana,
                                ordenada y fácil de entender para todos nuestros pacientes.
                            </p>
                        </div>

                        <div class="flex flex-col gap-3 sm:flex-row">
                            <a href="{{ route('login') }}"
                                class="inline-flex items-center justify-center rounded-2xl bg-cyan-600 px-6 py-3 text-base font-semibold text-white shadow-sm transition hover:bg-cyan-700">
                                Iniciar sesión
                            </a>

                            <a href="{{ route('registro') }}"
                                class="inline-flex items-center justify-center rounded-2xl bg-slate-100 px-6 py-3 text-base font-semibold text-slate-800 transition hover:bg-slate-200">
                                Registrarse
                            </a>
                        </div>

                        <div class="grid gap-3 sm:grid-cols-3">
                            <div class="rounded-2xl bg-slate-50 p-4 ring-1 ring-slate-200">
                                <p class="text-2xl font-bold text-cyan-700">Clara</p>
                                <p class="text-sm text-slate-600">Información entendible</p>
                            </div>

                            <div class="rounded-2xl bg-slate-50 p-4 ring-1 ring-slate-200">
                                <p class="text-2xl font-bold text-cyan-700">Humana</p>
                                <p class="text-sm text-slate-600">Atención cercana</p>
                            </div>

                            <div class="rounded-2xl bg-slate-50 p-4 ring-1 ring-slate-200">
                                <p class="text-2xl font-bold text-cyan-700">Fácil</p>
                                <p class="text-sm text-slate-600">Uso para todos</p>
                            </div>
                        </div>
                    </div>

                    {{-- IMAGEN PRINCIPAL --}}
                    <div class="relative">
                        <div class="absolute -inset-4 rounded-[2rem] bg-cyan-100 blur-2xl"></div>

                        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-cyan-100 via-white to-blue-100 p-4 ring-1 ring-slate-200">
                            @if (file_exists(public_path('images/home-clinica.jpg')))
                            <img
                                src="{{ asset('images/home-clinica.jpg') }}"
                                alt="Personal médico atendiendo a un paciente en Clínica D.S."
                                class="h-72 w-full rounded-2xl object-cover sm:h-96">
                            @else
                            <div class="flex h-72 w-full flex-col items-center justify-center rounded-2xl bg-white text-center sm:h-96">
                                <div class="mb-4 text-7xl">👩‍⚕️</div>
                                <p class="text-lg font-semibold text-slate-800">
                                    Imagen principal de la clínica
                                </p>
                                <p class="mt-2 max-w-sm text-sm text-slate-500">
                                    Guarda una imagen en:
                                    <span class="font-semibold">public/images/home-clinica.jpg</span>
                                </p>
                            </div>
                            @endif

                            <div class="mt-4 grid gap-3 sm:grid-cols-2">
                                <div class="rounded-2xl bg-white/90 p-4 shadow-sm">
                                    <p class="font-semibold text-slate-900">Atención cercana</p>
                                    <p class="text-sm text-slate-600">
                                        Pensada para pacientes de todas las edades.
                                    </p>
                                </div>

                                <div class="rounded-2xl bg-white/90 p-4 shadow-sm">
                                    <p class="font-semibold text-slate-900">Información clara</p>
                                    <p class="text-sm text-slate-600">
                                        Diseño simple, ordenado y fácil de usar.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>

            {{-- CONTACTO --}}
            <section id="contacto" class="rounded-3xl bg-slate-950 p-6 text-white shadow-sm">
                <div class="grid gap-6 lg:grid-cols-2 lg:items-center">

                    <div>
                        <span class="inline-flex rounded-full bg-cyan-500/10 px-4 py-2 text-sm font-semibold text-cyan-300 ring-1 ring-cyan-400/20">
                            📞 Contacto
                        </span>

                        <h2 class="mt-4 text-2xl font-bold sm:text-3xl">
                            ¿Necesitas comunicarte con Clínica D.S.?
                        </h2>

                        <p class="mt-3 leading-7 text-slate-300">
                            Estamos disponibles para brindarte información y orientación sobre nuestra atención médica.
                            Puedes comunicarte con nosotros mediante teléfono, correo o visitarnos en nuestra sede.
                        </p>
                    </div>

                    <div class="grid gap-3 sm:grid-cols-2">
                        <div class="rounded-2xl bg-white/10 p-4 ring-1 ring-white/10">
                            <p class="text-sm text-slate-300">Teléfono</p>
                            <p class="mt-1 text-lg font-bold">987 654 321</p>
                        </div>

                        <div class="rounded-2xl bg-white/10 p-4 ring-1 ring-white/10">
                            <p class="text-sm text-slate-300">Correo</p>
                            <p class="mt-1 break-words text-lg font-bold">contacto@clinicads.com</p>
                        </div>

                        <div class="rounded-2xl bg-white/10 p-4 ring-1 ring-white/10 sm:col-span-2">
                            <p class="text-sm text-slate-300">Dirección</p>
                            <p class="mt-1 text-lg font-bold">Av. Principal 123, Lima - Perú</p>
                        </div>
                    </div>

                </div>
            </section>

        </div>

    </main>

</body>

</html>