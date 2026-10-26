<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Harthora · Inmobiliaria de lujo</title>

    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-white text-slate-800 antialiased">

{{-- ===== Cabecera ===== --}}
<header class="border-b border-cyan-100">
</header>

<main>
    {{-- ===== Portada ===== --}}
    <section class="bg-gradient-to-b from-cyan-50 to-white">
        <div class="mx-auto grid max-w-6xl items-center gap-12 px-6 py-20 md:grid-cols-2 md:py-28">
            <div>
                <p class="mb-4 text-sm font-semibold uppercase tracking-[0.2em] text-cyan-600">
                    Inmobiliaria de lujo
                </p>
                <h1 class="text-4xl font-semibold leading-tight text-slate-900 md:text-5xl">
                    Viviendas excepcionales para quien busca algo más
                </h1>
                <p class="mt-6 max-w-md text-lg text-slate-600">
                    Villas, áticos y casas de campo seleccionadas en las mejores zonas de España,
                    con un equipo que te acompaña de la primera visita a la firma.
                </p>
                <div class="mt-10 flex flex-wrap gap-4">
                    <a href="#" class="rounded-full bg-cyan-500 px-7 py-3 font-medium text-white shadow-md hover:bg-cyan-600">
                        Ver catálogo
                    </a>
                    <a href="#" class="rounded-full border border-cyan-300 px-7 py-3 font-medium text-cyan-700 hover:bg-cyan-50">
                        Hazte cliente premium
                    </a>
                </div>
            </div>

            {{-- Bloque decorativo provisional, hasta que haya fotos --}}
            <div class="relative hidden aspect-[4/3] overflow-hidden rounded-3xl bg-gradient-to-br from-cyan-300 via-cyan-400 to-teal-500 shadow-xl md:block">
                <div class="absolute inset-x-8 bottom-8 rounded-2xl bg-white/90 p-5 backdrop-blur">
                    <p class="text-xs font-semibold uppercase tracking-widest text-cyan-600">Novedad premium</p>
                    <p class="mt-1 text-lg font-semibold text-slate-900">Villa con vistas al mar</p>
                    <p class="text-sm text-slate-500">Marbella · 5 dormitorios</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== Ventajas ===== --}}
    <section class="mx-auto max-w-6xl px-6 py-20">
        <h2 class="text-center text-3xl font-semibold text-slate-900">Por qué Harthora</h2>

        <div class="mt-12 grid gap-8 md:grid-cols-3">
            <article class="rounded-2xl border border-cyan-100 p-8 hover:shadow-lg">
                <h3 class="text-lg font-semibold text-cyan-700">Catálogo exclusivo</h3>
                <p class="mt-3 text-slate-600">
                    Los clientes premium ven las nuevas viviendas un mes antes que nadie.
                </p>
            </article>

            <article class="rounded-2xl border border-cyan-100 p-8 hover:shadow-lg">
                <h3 class="text-lg font-semibold text-cyan-700">Visitas a tu medida</h3>
                <p class="mt-3 text-slate-600">
                    Reserva una franja de lunes a viernes y un comercial te enseñará la casa.
                </p>
            </article>

            <article class="rounded-2xl border border-cyan-100 p-8 hover:shadow-lg">
                <h3 class="text-lg font-semibold text-cyan-700">Compra segura</h3>
                <p class="mt-3 text-slate-600">
                    Cada venta la revisa y valida nuestro equipo financiero.
                </p>
            </article>
        </div>
    </section>
</main>

{{-- ===== Pie ===== --}}
<footer class="border-t border-cyan-100 bg-cyan-50/50">
    <div class="mx-auto flex max-w-6xl flex-col items-center justify-between gap-2 px-6 py-8 text-sm text-slate-500 md:flex-row">
        <p><span class="font-semibold text-cyan-700">Harthora</span> · Inmobiliaria de lujo</p>
        <p>&copy; {{ date('Y') }} · Proyecto DWES</p>
    </div>
</footer>

</body>
</html>
