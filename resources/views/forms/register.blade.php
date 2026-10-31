<x-layouts.app title="Registro - Harthora">
    <section class="mx-auto max-w-2xl px-6 py-20">
        <h1 class="text-center text-3xl font-semibold text-slate-900">Crea tu cuenta</h1>
        <p class="mt-3 text-center text-slate-600">Guarda tus casas favoritas y solicita visitas.</p>

        <!--Campos del formulario -->
        <form class="mt-10 space-y-6" method="POST" action= {{route ('register')}}>
            @csrf
            <fieldset class="grid gap-6 md:grid-cols-2">
                <!--Nombre y apellidos -->
                <x-forms.input name="name" label="Nombre" type="text" required/>
                <x-forms.input name="last_name" label="Apellidos" type="text" required/>
            </fieldset>
            <fieldset class="grid gap-6 md:grid-cols-1">
                <!--Email y dirección-->
                <x-forms.input name="email" label="Correo Electrónico" type="email" required/>
                <x-forms.input name="tax_address" label="Dirección fiscal" type="text" required/>

            </fieldset>
            <fieldset class="grid gap-6 md:grid-cols-2">
                <!--Nif y telefono -->
                <x-forms.input name="nif" label="NIF/DNI" type="text" required/>
                <x-forms.input name="phone" label="Número de telefono" type="text" />
            </fieldset>

            <fieldset class="grid gap-6 md:grid-cols-1">
                <!--Contraseña y confirmación-->
                <x-forms.input name="password" label="Contraseña" type="password" required/>
                <x-forms.input name="password_confirmation" label="Confirmar contraseña" type="password" required/>
            </fieldset>

            <button type="submit" class="w-full rounded-full cursor-pointer bg-cyan-500 px-7 py-3 font-medium text-white shadow-md hover:bg-cyan-600">
                Crear cuenta
            </button>
        </form>

        <p class="mt-8 text-center text-ms text-slate-600">
            ¿Ya tienes cuenta? <br>
            <a href="{{ route('login') }}" class="font-medium text-cyan-700 hover:text-cyan-500">Inicia sesión</a>
        </p>


    </section>
</x-layouts.app>
