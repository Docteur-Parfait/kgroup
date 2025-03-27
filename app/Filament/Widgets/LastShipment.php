<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use App\Models\Shipment;
use Filament\Tables\Table;
use Filament\Support\Enums\FontWeight;
use App\Filament\Resources\ShipmentResource;
use Filament\Widgets\TableWidget as BaseWidget;

class LastShipment extends BaseWidget
{
    protected int | string | array $columnSpan = "full";


    protected static ?string $heading = "Les dernieres expéditions";

    protected static ?int $sort = 2;
    public function table(Table $table): Table
    {
        return $table
            ->query(
                ShipmentResource::getEloquentQuery()
            )
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at', "desc")
            ->columns([

                Tables\Columns\TextColumn::make('ref')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('booking.booking_number')
                    ->badge()->label("Booking number")
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('line.name')
                    ->weight(FontWeight::Bold)
                    ->sortable(),
                Tables\Columns\TextColumn::make('transport_mode')
                    ->weight(FontWeight::Bold)

                    ->sortable(),

                Tables\Columns\TextColumn::make('total_cost')
                    ->weight(FontWeight::Bold)
                    ->money("CAD")->color("danger")
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')->label("Delivry status")->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('payment_status')->label("Payment status")->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->badge()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
            ]);
    }

    // add reate button
    protected function getCreateButtonLabel(): string
    {
        return "Créer une expédition";
    }

    protected function getCreateButtonUrl(): string
    {
        return ShipmentResource::getUrl('create');
    }
}
