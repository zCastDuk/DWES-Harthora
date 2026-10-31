<x-layouts.app title="Harthora · Inmobiliaria de lujo">
    {{-- ===== Portada ===== --}}
    <section class="bg-gradient-to-b from-cyan-50 to-white">
        <div class="mx-auto grid max-w-6xl items-center gap-12 px-6 py-20 md:grid-cols-2 md:py-28">
            <div>
                <p class="mb-4 text-sm font-semibold uppercase tracking-[0.2em] text-cyan-600">
                    ¡Contacta con nosotros!
                </p>
                <h1 class="text-4xl font-semibold leading-tight text-slate-900 md:text-5xl">
                    La casa de tus sueños está a solo un click
                </h1>
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
                    <p class="text-xs font-semibold uppercase tracking-widest text-cyan-600">+34 123 456 789</p>
                    <p class="text-xs font-semibold uppercase tracking-widest text-cyan-600">info@harthora.com</p> <br>
                    <p class="text-xs font-semibold uppercase tracking-widest text-blue-950">Redes sociales</p>
                    <br>
                    <div class="flex flex-wrap gap-4">
                        <a><img width="24px" src="#"></a>
                        <a><img width="24px" src="#"></a>
                        <a><img width="24px" src="#"></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== Formulario de contacto ===== --}}
    <section class="mx-auto max-w-2xl px-6 py-20">
        <h2 class="text-center text-3xl font-semibold text-slate-900">Escríbenos</h2>
        <p class="mt-3 text-center text-slate-600">Te responderemos lo antes posible.</p>

        {{-- Mensaje de "gracias" tras enviar --}}
        @if (session('success'))
            <div class="mt-8 rounded-xl border border-cyan-200 bg-cyan-50 p-4 text-cyan-800">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST"  class="mt-10 space-y-6">
            @csrf

            {{-- Asunto --}}
            <div>
                <label for="subject" class="block text-sm font-medium text-slate-700">Asunto</label>
                <input type="text" id="subject" name="subject" value="{{ old('subject') }}"
                       class="mt-2 w-full rounded-xl border border-cyan-200 px-4 py-3 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-200">
                @error('subject')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Correo --}}
            <div>
                <label for="email" class="block text-sm font-medium text-slate-700">Correo electrónico</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                       class="mt-2 w-full rounded-xl border border-cyan-200 px-4 py-3 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-200">
                @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Mensaje --}}
            <div>
                <label for="message" class="block text-sm font-medium text-slate-700">Mensaje</label>
                <textarea id="message" name="message" rows="5"
                          class="mt-2 w-full rounded-xl border border-cyan-200 px-4 py-3 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-200">{{ old('message') }}</textarea>
                @error('message')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                    class="w-full rounded-full bg-cyan-500 px-7 py-3 font-medium text-white shadow-md hover:bg-cyan-600">
                Enviar
            </button>
        </form>
    </section>
</x-layouts.app>
