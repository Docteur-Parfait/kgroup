<div>
    <div class="bg-white rounded-lg shadow-lg px-8 py-10 max-w-xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center">
                <img class="h-12 mr-2" src="{{ asset('logo.png') }}" alt="Logo" />

            </div>
            <div class="text-gray-700">
                <div class="font-bold text-lg mb-2">ESTIMATION PROVISOIRE</div>
                <div class="text-sm">Date: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</div>
                <div class="text-sm">N°: {{ $factureRef }}</div>
            </div>
        </div>
        <div class="border-b-2 border-gray-300 pb-8 mb-8">
            <h2 class="text-2xl font-bold mb-4">Destinée a:</h2>
            <div class="text-gray-700 mb-2">{{ $data['sender_info'][0]['name'] }}</div>
            {{-- <div class="text-gray-700 mb-2">{{ auth()->user()->adresse }}</div>
            <div class="text-gray-700 mb-2">{{ auth()->user()->telephone }}</div> --}}
            <div class="text-gray-700">{{ $data['sender_info'][0]['email'] }}</div>
        </div>
        <table class="w-full text-left mb-8">
            <thead>
                <tr>
                    <th class="text-gray-700 font-bold uppercase py-2">Description</th>
                    <th class="text-gray-700 font-bold uppercase py-2">Quantité</th>
                    <th class="text-gray-700 font-bold uppercase py-2">Prix</th>
                    <th class="text-gray-700 font-bold uppercase py-2">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($facture as $fact)
                    <tr>
                        <td class="py-4 text-gray-700">{{ $fact['description'] }}</td>
                        <td class="py-4 text-gray-700">{{ $fact['quantity'] }}</td>
                        <td class="py-4 text-gray-700">${{ $fact['price'] }}</td>
                        <td class="py-4 text-gray-700">${{ $fact['total'] }}</td>
                    </tr>
                @endforeach

            </tbody>
        </table>
        {{-- <div class="flex justify-end mb-8">
            <div class="text-gray-700 mr-2">Total provisoir:</div>
            <div class="text-gray-700">${{ array_sum(array_column($facture, 'total')) }}</div>
        </div> --}}

        <div class="flex justify-end mb-8">
            <div class="text-gray-700 mr-2">Total:</div>
            <div class="text-gray-700 font-bold text-xl">${{ array_sum(array_column($facture, 'total')) }}</div>
        </div>
        <div class="border-t-2 border-gray-300 pt-8 mb-8">
            <div class="text-gray-700 mb-2">Ceci est une estimation provisoire. Vous recevrez la facture définitive par
                email
                une fois le produit expédié.</div>

            <div class="text-gray-700">Kelise Groupe - Lomé, Togo</div>
            <br>
            {{-- <button class="btn bg-blue-600 btn-primary p-2 rounded text-white" wire:click="validateForm">Valider la
                commande</button> --}}
            <x-filament-panels::form wire:submit="validateForm">
                {{-- {{ $this->form }} --}}

                <x-filament-panels::form.actions :actions="$this->getFormActions()" />
            </x-filament-panels::form>
        </div>
    </div>
</div>
