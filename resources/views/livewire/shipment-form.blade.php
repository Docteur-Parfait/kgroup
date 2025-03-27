<div>
    <style>
        .fi-btn-color-success {
            background-color: blue !important
        }
    </style>



    @if ($traiter == false)
        <h1 class="mb-8 text-center text-3xl font-semibold">Veuillez remplir ce formulaire pour envoyer votre demande
            d 'expédition</h1>
        <x-filament-panels::form wire:submit="create">
            {{ $this->form }}

            <x-filament-panels::form.actions :actions="$this->getFormActions()" />
        </x-filament-panels::form>
    @else
        <h1 class="mb-8 text-center text-3xl font-semibold">Voici une estimation provisoire de votre commande, valider
            pour recevoir la facture définitive</h1>
        @livewire('facture-component', ['facture' => $facture, 'factureRef' => $factureRef, 'data' => $data])
    @endif

</div>
