<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Line;
use Filament\Tables;
use App\Models\Booking;
use App\Models\Product;
use App\Models\Stepper;
use Filament\Forms\Get;
use App\Models\Shipment;
use Filament\Forms\Form;
use App\Models\Emballage;
use Filament\Tables\Table;
use Forms\Components\Select;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use App\Tables\Columns\ShipmentColum;
use App\Tables\Columns\ShipmentColumn;
use Filament\Support\Enums\FontWeight;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\Split;
use App\Infolists\Components\QrcodeEntry;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use App\Infolists\Components\MultipleImageEntry;
use App\Filament\Resources\ShipmentResource\Pages;
use Filament\Infolists\Components\RepeatableEntry;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Wallo\FilamentSelectify\Components\ButtonGroup;
use Wallo\FilamentSelectify\Components\ToggleButton;
use Filament\Infolists\Components\TextEntry\TextEntrySize;
use DesignTheBox\BarcodeField\Forms\Components\BarcodeInput;
use App\Filament\Resources\ShipmentResource\RelationManagers;

class ShipmentResource extends Resource
{
    protected static ?string $model = Shipment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Gestion des expéditions';

    protected static ?string $navigationLabel = 'Expéditions';

    protected static ?int $navigationSort = 1;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->orderBy('id', "DESC");
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Section::make('Informations de l\'expédition')
                    ->schema([
                        // BarcodeInput::make('barcode')
                        //     ->icon('heroicon-o-arrow-right') // Specify your Heroicon name here
                        //     ->required(),
                        Forms\Components\Select::make('booking_id')->label("Booking number")
                            ->options(Booking::all()->pluck('booking_number', 'id'))->searchable()->hiddenOn("create"),
                        Forms\Components\Select::make('line_id')->label("Choisir la ligne")
                            ->options(Line::all()->pluck('name', 'id'))
                            ->live()
                            ->required(),
                        Forms\Components\Select::make('transport_mode')->label("Mode de transport")
                            ->options(fn(Get $get): array =>  $get("line_id") == null ? [] : getLineTransportMode($get("line_id")))
                            ->required()->live()->hidden(fn(Get $get): bool =>  $get("line_id") == null),

                        ToggleButton::make('ramassage')
                            ->offLabel('Non')
                            ->onLabel('Oui')->live()->hidden(fn(Get $get): bool => $get("line_id") == null)
                            ->default(false),
                        Forms\Components\Repeater::make('info_ramassage')->label('Informations de ramassage')
                            ->schema([
                                Forms\Components\Select::make('ville')->label("Ville de ramassage")
                                    ->options(getVilles())->required(),
                                Forms\Components\TextInput::make('address')
                                    ->required()->label('Adresse')
                                    ->placeholder("Adresse de ramassage"),
                            ])->columns(2)
                            ->hidden(fn(Get $get): bool => $get("ramassage") == false)
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
                            ->default(0.00)->hidden(fn(Get $get): bool => $get("transport_mode") == "BATEAU")
                            ->columnSpanFull(),
                        Forms\Components\Repeater::make('emballage_prices')->label("Choix d'emballages")
                            ->schema([
                                Forms\Components\Select::make('emballage_id')->label("Choisir l'emballage")
                                    ->options(Emballage::all()->pluck('name', 'id')),
                                Forms\Components\TextInput::make('quantity')
                                    ->label('Quantité')
                                    ->numeric()
                                    ->default(0),
                            ])->columnSpanFull()->addActionLabel('Ajouter un autre emballage')->hidden(fn(Get $get): bool => $get("transport_mode") == "AVION"),
                        Forms\Components\Textarea::make('details')
                            ->label('Ajouter des détails')->columnSpanFull(),
                        Forms\Components\FileUpload::make('pictures')->multiple()->image()->columnSpanFull()->maxFiles(10)->panelLayout('grid')->reorderable()
                            ->directory('chapters'),
                    ])
                    ->columns(2),



                Forms\Components\Section::make("Etapes d'expédition")
                    ->schema([
                        Forms\Components\Repeater::make('tracking_info')->label('Etapes')
                            ->schema([
                                Forms\Components\Select::make('stepper_id')
                                    ->label('Etape')
                                    ->options(Stepper::all()->pluck('name', 'id')),

                                Forms\Components\Textarea::make('description'),
                                Forms\Components\Toggle::make('valider')
                                    ->label('Terminé')
                                    ->default(false),
                            ])->columnSpanFull()->addActionLabel('Ajouter une étape'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Validation')
                    ->schema([


                        Forms\Components\TextInput::make('total_cost')
                            ->required()->label('Coût total')
                            ->numeric()->suffix("$ CAD")
                            ->default(0.00),

                        ButtonGroup::make('status')->label("Delivrery status")
                            ->options([
                                'pending' => 'En attente',
                                'in_progress' => 'En cours',
                                'completed' => 'Terminé',
                                'canceled' => 'Annulé',
                            ])->default('pending')->columnSpanFull(),


                        ButtonGroup::make('payment_status')->label('Payment status')
                            ->options([
                                'pending' => 'En attente',
                                'in_progress' => 'En cours',
                                'completed' => 'Terminé',
                                'canceled' => 'Annulé',
                            ])->default('pending')->columnSpanFull(),




                    ])
                    ->columns(2),




            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\Layout\Stack::make([
                    ShipmentColumn::make('ref'),
                ])->space(3),

            ])

            ->contentGrid([
                'md' => 2,
                "sm" => 2,
                "xl" => 3,

            ])
            // ->columns([
            //     Tables\Columns\TextColumn::make('ref')
            //         ->badge()
            //         ->sortable(),
            //     Tables\Columns\TextColumn::make('booking.booking_number')
            //         ->badge()->label("Booking number")
            //         ->sortable()
            //         ->toggleable(isToggledHiddenByDefault: false),
            //     Tables\Columns\TextColumn::make('line.name')
            //         ->weight(FontWeight::Bold)
            //         ->sortable(),
            //     Tables\Columns\TextColumn::make('transport_mode')
            //         ->weight(FontWeight::Bold)

            //         ->sortable(),

            //     Tables\Columns\TextColumn::make('total_cost')
            //         ->weight(FontWeight::Bold)
            //         ->money("CAD")->color("danger")
            //         ->sortable(),
            //     Tables\Columns\TextColumn::make('status')->label("Delivery status")->badge()
            //         ->searchable(),
            //     Tables\Columns\TextColumn::make('payment_status')->label("Payment status")->badge()
            //         ->searchable(),
            //     Tables\Columns\TextColumn::make('created_at')
            //         ->dateTime()
            //         ->badge()
            //         ->sortable()
            //         ->toggleable(isToggledHiddenByDefault: false),

            // ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make("Informations de l'expédition")
                    ->schema([
                        Split::make([
                            Grid::make(2)
                                ->schema([
                                    Group::make([
                                        TextEntry::make('ref')->label("Numero de suivi")->weight(FontWeight::Bold)->size(TextEntrySize::Large)->color("danger"),
                                        TextEntry::make('booking.booking_number')->label("Booking number")->weight(FontWeight::Bold)->size(TextEntrySize::Large)->color("danger"),
                                    ]),
                                    Group::make([
                                        TextEntry::make('transport_mode')->label("Mode de transport"),
                                        IconEntry::make('ramassage')->label("Ramassage")->boolean(),
                                    ])
                                ]),
                            QrcodeEntry::make('ref'),
                            // ImageEntry::make('image')

                            //     ->height(200)
                            //     ->grow(false),
                        ])->from('lg'),



                        Grid::make(2)
                            ->schema([
                                Group::make([
                                    RepeatableEntry::make("sender_info")
                                        ->schema([
                                            TextEntry::make('name')->label("Nom de l'expéditeur"),
                                            TextEntry::make('address')->label("Adresse de l'expéditeur"),
                                            TextEntry::make('phone')->label("Téléphone de l'expéditeur"),
                                            TextEntry::make('email')->label("Email de l'expéditeur"),
                                        ]),

                                ]),
                                Group::make([
                                    RepeatableEntry::make("receiver_info")
                                        ->schema([
                                            TextEntry::make('name')->label("Nom du destinataire"),
                                            TextEntry::make('address')->label("Adresse du destinataire"),
                                            TextEntry::make('phone')->label("Téléphone du destinataire"),
                                            TextEntry::make('email')->label("Email du destinataire"),
                                        ]),
                                ]),
                            ]),
                    ]),
                Section::make("Achat externe")
                    ->schema([
                        RepeatableEntry::make('other_prices')
                            ->schema([
                                TextEntry::make('product_id')->formatStateUsing(fn($state): string => Product::find($state)->name)->label("Produit"),
                                TextEntry::make('quantity')->label("Quantité"),
                            ])->columns(2),
                    ]),
                Section::make("Details de la commande")
                    ->schema([
                        TextEntry::make('weight')->label("Poids estimatif")->suffix("Kg"),
                        RepeatableEntry::make('emballage_prices')
                            ->schema([
                                TextEntry::make('emballage_id')->formatStateUsing(fn($state): string => Emballage::find($state)->name)->label("Emballage"),
                                TextEntry::make('quantity')->label("Quantité"),
                            ])->columns(2),
                        MultipleImageEntry::make('pictures'),
                        TextEntry::make('details')->label("Détails"),
                    ]),
                Section::make("Etapes d'expédition")
                    ->schema([
                        RepeatableEntry::make('tracking_info')
                            ->schema([
                                TextEntry::make('stepper.name')->label("Étape"),
                                TextEntry::make('description')->label("Description"),
                                IconEntry::make('valider')->label("Terminé")->boolean(),
                            ]),
                    ]),
                Section::make("Validation")
                    ->schema([
                        TextEntry::make('total_cost')->label("Coût total")->suffix("$ CAD")->weight(FontWeight::Bold),
                        TextEntry::make('status')->label("Delivre status")->badge(),
                        TextEntry::make('payment_status')->label("Payment status")->badge(),
                    ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListShipments::route('/'),
            'create' => Pages\CreateShipment::route('/create'),
            'view' => Pages\ViewShipment::route('/{record}'),
            'edit' => Pages\EditShipment::route('/{record}/edit'),
        ];
    }
}
