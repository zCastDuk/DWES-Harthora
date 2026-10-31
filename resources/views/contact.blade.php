<x-layouts.app title="Contacto · Harthora">
    <section class="bg-cyan-600">
        <div class="mx-auto grid max-w-6xl gap-12 px-6 py-20 md:grid-cols-2 md:items-center">

            <div class="text-white">
                <h2 class="text-4xl font-semibold">Estemos en contacto</h2>
                <p class="mt-4 max-w-md text-cyan-50">
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sed voluptas delectus alias
                    magni velit!
                </p>

                <div class="mt-10 space-y-3 text-cyan-50">
                    <p>Teléfono</p>
                    <p>Email</p>
                    <p>Ubicación</p>

                    <div class="flex gap-4 pt-4">
                        <a href="#" class="flex h-10 w-10 items-center justify-center rounded-full bg-white/20 hover:bg-white/30"><img alt="Instagram" src="../img/logos/instagram.webp"></a>
                        <a href="#" class="flex h-10 w-10 items-center justify-center rounded-full bg-white/20 hover:bg-white/30"><img alt="Facebook" src="../img/logos/facebook.png"></a>
                        <a href="#" class="flex h-10 w-10 items-center justify-center rounded-full bg-white/20 hover:bg-white/30"><img alt="LinkedIn" src="../img/logos/linkedIn.webp"></a>
                    </div>
                </div>
            </div>

            <div class="rounded-3xl bg-white p-8 shadow-xl">
                <form class="space-y-6" method="POST" action="{{route ('contact')}}">
                    @csrf
                    <div class="grid md:grid-cols-1">
                        <x-forms.label name="name" label="Nombre"/>
                        <x-forms.input name="name" placeholder="Déjanos tu nombre" type="text" required/>
                        <x-forms.label name="email" label="Email"/>
                        <x-forms.input name="email" placeholder="Tu email para poder contactar" type="email" required/>
                    </div>
                    <div>
                        <x-forms.label name="subject" label="Mensaje"/>
                        <x-forms.textarea id="subject" name="subject" placeholder="Cuentanos tu caso"/>
                    </div>

                    <button type="submit"
                            class="w-full cursor-pointer rounded-full bg-cyan-500 px-7 py-3 font-medium text-white shadow-md hover:bg-cyan-600">
                        Enviar mensaje
                    </button>
                </form>
            </div>

        </div>
    </section>
</x-layouts.app>
