@extends('layouts.layout')

@section('content')
    @if (is_null($shipment))
        <div class="alert alert-danger">
            Le numéro de suivi est incorrect.
        </div>
    @else
        <div class="bg-white">
            <div class="max-w-screen-md mx-auto px-4 sm:px-6 lg:px-8 flex flex-col justify-between">

                <div class="text-center">
                    <p class="mt-4 text-sm leading-7 text-gray-500 font-regular">
                        SUVI DE L'EXPEDITION
                    </p>
                    <h3 class="text-2xl sm:text-5xl leading-normal font-bold tracking-tight text-gray-900">
                        N°<span class="text-indigo-600">{{ $shipment->ref }}</span>
                    </h3>

                </div>

                <div class="mt-20">
                    <ul class="">
                        @foreach ($shipment->tracking_info as $step)
                            <li class="text-left mb-10">
                                <div class="flex flex-row items-start">
                                    <div class="flex flex-col items-center justify-center mr-5">
                                        <div
                                            class="flex items-center justify-center h-20 w-20 rounded-full bg-indigo-500 text-white border-4 border-white text-xl font-semibold">
                                            <i class="{{ getStepper($step['stepper_id'])->icon }}"></i>
                                        </div>
                                        <i class="fas fa-arrow-down    "></i>

                                    </div>
                                    <div class="bg-gray-100 p-5 pb-10 ">
                                        <h4 class="text-lg leading-6 font-semibold text-gray-900">
                                            {{ getStepper($step['stepper_id'])->name }}</h4>
                                        <p class="mt-2 text-base leading-6 text-gray-500">
                                            {{ $step['description'] }}
                                        </p>
                                    </div>
                                </div>
                            </li>
                        @endforeach


                    </ul>
                </div>

            </div>
        </div>
    @endif
@endsection
