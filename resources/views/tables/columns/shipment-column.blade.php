<div>
    {{-- {{ $getState() }} --}}

    <div class="  overflow-hidden ">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                N° {{ $getRecord()->ref }}
            </h3>

        </div>
        <div class="border-t border-gray-200">
            <dl>
                {{-- <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Booking number
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $getRecord()->booking->booking_number }}
                    </dd>
                </div> --}}
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Transport mode
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $getRecord()->transport_mode }}
                    </dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Sender name
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $getRecord()->sender_info[0]['name'] }}
                    </dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Receiver name
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $getRecord()->receiver_info[0]['name'] }}
                    </dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Total cost
                    </dt>
                    <dd class="mt-1 text-sm text-red font-semibold sm:mt-0 sm:col-span-2">
                        ${{ $getRecord()->total_cost }} CAD
                    </dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Delivery status
                    </dt>
                    <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
                        {{ $getRecord()->status }}
                    </dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Payment status
                    </dt>
                    <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
                        {{ $getRecord()->payment_status }}
                    </dd>
                </div>
            </dl>
        </div>
    </div>
</div>
