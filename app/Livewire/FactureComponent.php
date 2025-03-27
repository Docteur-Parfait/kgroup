<?php

namespace App\Livewire;

use App\Models\Line;
use App\Models\User;
use Livewire\Component;
use App\Models\Shipment;
use Filament\Forms\Form;
use Filament\Tables\Actions\Action;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Notifications\Actions\Action as NotificationAction;



class FactureComponent extends Component implements HasForms
{
    use InteractsWithForms;
    public $facture;
    public $factureRef;
    public $data;

    public function render()
    {
        // dd($this->data);
        return view('livewire.facture-component');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public function getFormActions(): array
    {
        return [
            Action::make('Update')->label("Valider la commande")
                ->color('success')
                ->action('validateForm'),
        ];
    }

    public function areFormActionsSticky(): bool
    {
        return false;
    }

    public function getFormActionsAlignment(): string
    {
        return 'start'; // Ou 'center', 'end' selon ton besoin
    }

    public function validateForm()
    {

        $products = [];
        $emballages = [];
        foreach ($this->data["other_prices"] as $key => $value) {

            array_push($products, $value);
        }

        foreach ($this->data["emballage_prices"] as $key => $value) {
            array_push($emballages, $value);
        }
        // dd($this->data);
        $line = Line::find($this->data["line_id"]);
        $shipmentData = [
            "ref" => $this->factureRef,

            "line_id" => $this->data["line_id"],
            "transport_mode" => $this->data["transport_mode"],
            "departure_agency" => "KELISE " . $line->departureCountry->name,
            "arrival_agency" => "KELISE " . $line->arrivalCountry->name,
            "ramassage" => $this->data["ramassage"],
            "info_ramassage" => $this->data["info_ramassage"],
            "sender_info" => [array_values($this->data['sender_info'])[0]],
            "receiver_info" => [array_values($this->data['receiver_info'])[0]],
            "details" => $this->data["details"],
            "other_prices" => $products,
            "emballage_prices" => $emballages,
            "weight" => $this->data["weight"] ?? 0,
            "total_cost" => array_sum(array_column($this->facture, 'total')),
            "pictures" => $this->data["pictures"],
        ];

        // dd($shipmentData);
        $shipment = new Shipment();
        $shipment->fill($shipmentData);
        $shipment->save();

        Notification::make()
            ->title('Nouvelle commande')
            ->success()
            ->actions([
                NotificationAction::make('view')
                    ->label('Voir la commande')
                    ->url(route("filament.admin.resources.shipments.view", $shipment))
                    ->button()
                    ->markAsRead(),
            ])
            ->body("Vous avez une nouvelle demande d'expedition sur la ligne {$line->name}")
            ->sendToDatabase(User::where("email", "admin@gmail.com")->first());


        Notification::make("Facture envoyée")->success();

        return redirect()->route('shipping');
    }
}
