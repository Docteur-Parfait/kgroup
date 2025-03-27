<?php

namespace App\Livewire;

use Filament\Forms;
use App\Models\Line;
use App\Models\Product;
use Livewire\Component;
use App\Models\Shipment;
use Filament\Forms\Form;
use App\Models\Emballage;


use App\Models\TransportMode;
use Illuminate\Support\HtmlString;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use RealRashid\SweetAlert\Facades\Alert;
use Filament\Forms\Concerns\InteractsWithForms;
use Wallo\FilamentSelectify\Components\ToggleButton;

class ShipmentForm extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public $traiter = false;

    public $facture = [];
    public $factureRef;

    public function mount(): void
    {
        $this->form->fill(shipSeed());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Section::make('Informations de l\'expédition')
                    ->schema([
                        Forms\Components\Select::make('line_id')->label("Choisir la ligne")
                            ->options(Line::all()->pluck('name', 'id'))
                            ->live()
                            ->required(),
                        Forms\Components\Select::make('transport_mode')->label("Mode de transport")
                            ->options(!isset($this->data['line_id']) ? [] : getLineTransportMode($this->data['line_id']))
                            ->required()->live()->hidden(!isset($this->data['line_id'])),


                        ToggleButton::make('ramassage')
                            ->offLabel('Non')
                            ->onLabel('Oui')->live()->hidden(isset($this->data['line_id']) ? $this->data['line_id'] == false : true)
                            ->default(false),
                        Forms\Components\Repeater::make('info_ramassage')->label('Informations de ramassage')
                            ->schema([
                                Forms\Components\Select::make('ville')->label("Ville de ramassage")
                                    ->options(getVilles())->required(),
                                Forms\Components\TextInput::make('address')

                                    ->required()->label('Adresse')->required()
                                    ->placeholder("Adresse de ramassage"),

                            ])->columns(2)
                            ->hidden(!isset($this->data['ramassage']) || $this->data['ramassage'] == false)
                            ->reorderable(false)
                            ->deletable(false)
                            ->addable(false),
                    ])
                    ->columns(2),

                Forms\Components\Section::make("Informations d'expédition")
                    ->schema([

                        Forms\Components\Repeater::make('sender_info')->label('Expéditeur')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()->label('Nom')
                                    ->placeholder("Nom de l'expéditeur"),
                                Forms\Components\TextInput::make('address')
                                    ->required()->label('Adresse')
                                    ->placeholder("Adresse de l'expéditeur"),
                                Forms\Components\TextInput::make('phone')
                                    ->required()->label('Téléphone')
                                    ->placeholder("Téléphone de l'expéditeur"),
                                Forms\Components\TextInput::make('email')
                                    ->required()->label('Email')
                                    ->placeholder('Email de l\'expéditeur'),
                            ])
                            ->reorderable(false)
                            ->deletable(false)
                            ->addable(false),
                        Forms\Components\Repeater::make('receiver_info')->label('Destinataire')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()->label('Nom')
                                    ->placeholder('Nom du destinataire'),
                                Forms\Components\TextInput::make('address')
                                    ->required()->label('Adresse')
                                    ->placeholder('Adresse du destinataire'),
                                Forms\Components\TextInput::make('phone')
                                    ->required()->label('Téléphone')
                                    ->placeholder('Téléphone du destinataire'),
                                Forms\Components\TextInput::make('email')
                                    ->required()->label('Email')
                                    ->placeholder('Email du destinataire'),
                            ])
                            ->reorderable(false)
                            ->deletable(false)
                            ->addable(false),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Achat externe')
                    ->schema([
                        Forms\Components\Repeater::make('other_prices')->label('Autres prix')
                            ->schema([
                                Forms\Components\Select::make('product_id')->label("Choisir le produit")
                                    ->options(Product::all()->pluck('name', 'id')),

                                Forms\Components\TextInput::make('quantity')
                                    ->label('Quantité')
                                    ->numeric()
                                    ->default(0),
                            ])->columnSpanFull()->addActionLabel('Ajouter un autre achat'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Details de la commande')
                    ->schema([
                        Forms\Components\TextInput::make('weight')
                            ->required()->label('Poids estimatif (Le poids final sera communiqué après validation)')
                            ->numeric()->suffix("Kg")
                            ->default(0.00)->hidden(isset($this->data['transport_mode']) ? $this->data['transport_mode'] == "BATEAU" : true)->columnSpanFull(),
                        Forms\Components\Repeater::make('emballage_prices')->label("Choix d'emballages")
                            ->schema([
                                Forms\Components\Select::make('emballage_id')->label("Choisir l'emballage")
                                    ->options(Emballage::all()->pluck('name', 'id')),
                                Forms\Components\TextInput::make('quantity')
                                    ->label('Quantité')
                                    ->numeric()
                                    ->default(0),
                            ])->columnSpanFull()->addActionLabel('Ajouter un autre emballage')->hidden(isset($this->data['transport_mode']) ? $this->data['transport_mode'] == "AVION" : true),

                        Forms\Components\FileUpload::make('pictures')->multiple()->image()->columnSpanFull()->maxFiles(10)->panelLayout('grid')->reorderable()
                            ->directory('shipment')->label('Ajouter des photos'),
                        Forms\Components\Textarea::make('details')
                            ->label('Ajouter des détails')->columnSpanFull(),


                    ])
                    ->columns(2),





            ])
            ->statePath('data');
    }

    public function areFormActionsSticky(): bool
    {
        return false;
    }

    public function getFormActionsAlignment(): string
    {
        return 'start'; // Ou 'center', 'end' selon ton besoin
    }



    public function getFormActions(): array
    {
        return [
            Action::make('Update')->label("Traiter la commande")
                ->color('success')
                ->submit('create'),
        ];
    }

    public function getValideForm(): array
    {
        return [
            Action::make('update')->label("Valider la commande")
                ->color('success')
                ->submit('validateForm'),
        ];
    }

    public function validateForm()
    {

        dd($this->data);
    }


    public function create(): void
    {
        // $registerData = $this->form->getState();
        // dd($this->data["other_prices"]);


        $facture = [];
        $data = $this->form->getState();

        $this->factureRef = strtoupper(uniqid());


        $line = Line::find($data["line_id"]);

        $prix_kilo = 0;

        if ($data["transport_mode"] == "AVION") {
            foreach ($line->prices as $price) {
                if ($price["transport_mode"] == $data["transport_mode"]) {
                    $prix_kilo = $price["price"];
                }
            }

            array_push($facture, [
                "description" => "Expédition " . $line->name,
                "quantity" => $data["weight"],
                "price" => $prix_kilo,
                "total" => $prix_kilo * $data["weight"],
            ]);
        }

        foreach ($data["emballage_prices"] as $value) {
            $emballage = Emballage::find($value["emballage_id"]);
            array_push($facture, [
                "description" => $emballage->name,
                "quantity" => $value["quantity"],
                "price" => $emballage->price,
                "total" => $emballage->price * $value["quantity"],
            ]);
        }


        foreach ($data["other_prices"] as $value) {
            $product = Product::find($value["product_id"]);
            array_push($facture, [
                "description" => $product->name,
                "quantity" => $value["quantity"],
                "price" => $product->price,
                "total" => $product->price * $value["quantity"],
            ]);
        }

        // dd($facture);

        $this->facture = $facture;

        $this->traiter = true;

        $this->data = $data;

        session()->flash('traitement', "Traitement valider");
    }
    public function render()
    {
        return view('livewire.shipment-form');
    }
}
