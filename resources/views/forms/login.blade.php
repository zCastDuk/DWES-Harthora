<x-layouts.app title="Login - Harthora">
    <section class="mx-auto max-w-2xl px-6 py-20">
        <h1 class="text-center text-3xl font-semibold text-slate-900">Crea tu cuenta</h1>
        <p class="mt-3 text-center text-slate-600">Guarda tus casas favoritas y solicita visitas.</p>

        <!--Campos del formulario -->
        <form class="mt-10 space-y-6" method="POST" action= {{route ('login')}}>
            @csrf
            <fieldset class="grid gap-6 md:grid-cols-1">
                <x-forms.input name="email" label="Correo Electrónico" type="email" required/>
                <x-forms.input name="password" label="Contraseña" type="password" required/>
            </fieldset>

            <button type="submit" class="w-full rounded-full cursor-pointer bg-cyan-500 px-7 py-3 font-medium text-white shadow-md hover:bg-cyan-600">
                Iniciar sesión
            </button>
        </form>

        <p class="mt-8 text-center text-sm text-slate-600">
            ¿No tienes cuenta? <br>
            <a href="{{ route('register') }}" class="font-medium text-cyan-700 hover:text-cyan-500">¡Crea tu cuenta ahora!</a>
        </p>


    </section>
</x-layouts.app>
