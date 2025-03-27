<section class="relative w-full px-8 text-gray-700 bg-white body-font" data-tails-scripts="//unpkg.com/alpinejs">
    <div class="container flex flex-col flex-wrap items-center justify-between py-5 mx-auto md:flex-row max-w-7xl">
        <a href="{{ route('welcome') }}"
            class="relative z-10 flex items-center w-auto text-2xl font-extrabold leading-none text-black select-none"><img
                src="{{ asset('assets/logo.png') }}" class="h-12" alt=""></a>


        <div class="relative z-10 inline-flex items-center space-x-3 md:ml-5 lg:justify-end">
            <a href="{{ route('shipping') }}"
                class="inline-flex items-center justify-center px-4 py-2 text-base font-medium leading-6 text-gray-600 whitespace-no-wrap bg-white border border-gray-200 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:shadow-none"
                data-rounded="rounded-md">
                Demande d'expédition
            </a>

        </div>
    </div>
</section>
