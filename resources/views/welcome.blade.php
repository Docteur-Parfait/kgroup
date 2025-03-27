@extends('layouts.layout')

@section('content')
    <!-- hero-16 -->
    <section class="relative"
        style="background-image: url('{{ asset('assets/mer2.jpg') }}'); background-color: rgba(0, 0, 0, 0.5); background-blend-mode: overlay; background-position: bottom; background-size: cover; background-repeat: no-repeat;">
        <div class="absolute inset-0 bg-gradient-to-b from-black to-transparent opacity-30"></div>

        <div class="relative z-20 px-4 py-24 mx-auto text-center text-white max-w-7xl lg:py-32">
            <div class="flex flex-wrap text-white">
                <div class="relative w-full px-4 mx-auto text-center xl:flex-grow-0 xl:flex-shrink-0">

                    <h1 class="mt-0 mb-2 text-4xl font-bold text-white sm:text-5xl lg:text-7xl">Envoyez et recevez vos
                        colis
                        en toute sécurité</h1>

                </div>
            </div>
        </div>

        <div class="relative z-30 h-48 px-10 bg-white lg:h-32">
            <form action="{{ route('suivi') }}" method="GET"
                class="flex flex-col items-center h-auto max-w-lg p-6 mx-auto space-y-3 overflow-hidden transform -translate-y-12 bg-white rounded-lg shadow-md lg:h-24 lg:max-w-3xl lg:flex-row lg:space-y-0 lg:space-x-3">

                <div class="w-full h-12 border-2 border-gray-200 rounded-lg lg:border-0 lg:w-auto lg:flex-1">
                    <input type="text" name="ref"
                        class="w-full h-full px-4 font-medium text-gray-700 rounded-lg sm:text-lg focus:bg-gray-50 focus:outline-none"
                        data-rounded="rounded-lg" placeholder="Enter un numéro de suivi" required>
                </div>

                <div class="w-full h-full lg:w-auto">
                    <button type="submit"
                        class="inline-flex items-center justify-center w-full h-full px-4 py-2 text-base font-medium leading-6 text-white whitespace-no-wrap bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 lg:w-64"
                        data-primary="indigo-600" data-rounded="rounded-md">Rechercher</button>
                </div>
            </form>
        </div>

    </section>

    <!-- AlpineJS Library -->

    <!-- blog-03 -->
    <section class="w-full py-8 bg-white ">
        <div class="px-10 mx-auto max-w-7xl">


            <div class="grid grid-cols-12 gap-6">
                @foreach ($pubs as $pub)
                    <div class="relative col-span-12 mb-10 space-y-4 md:col-span-6 lg:col-span-4">
                        <a href="#_" class="relative block w-full h-64 overflow-hidden rounded">
                            <img class="object-cover object-center w-full h-full transition duration-500 ease-out transform scale-100 hover:scale-105"
                                src="{{ asset('storage/' . $pub->image) }}">
                        </a>

                    </div>
                @endforeach

            </div>


        </div>
    </section>
@endsection
