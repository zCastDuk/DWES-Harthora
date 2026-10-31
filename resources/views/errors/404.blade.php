<x-layouts.app title="404">
    <section class="bg-white">
        <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
            <div class="mx-auto max-w-screen-sm text-center">
                <h1 class="mb-4 text-7xl tracking-tight font-extrabold lg:text-9xl text-primary-600 text-cyan-500">404</h1>
                <p class="mb-4 text-3xl tracking-tight font-bold text-cyan-700 md:text-4xl">Página no encontrada.</p>
                <p class="mb-4 text-lg font-light text-cyan-900 ">Lo sentimos, parece que esta página no está disponible. :( </p>
                <a href="{{route ('home')}}" class="inline-flex text-cyan-950 bg-primary-600 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center my-4">Volver al inicio</a>
            </div>
        </div>
    </section>
</x-layouts.app>
