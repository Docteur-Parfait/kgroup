<?php

namespace App\Filament\Resources\ShipmentResource\Pages;

use Filament\Actions;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\ShipmentResource;

class ViewShipment extends ViewRecord
{
    protected static string $resource = ShipmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('generate')
                ->label("QR Code")->icon('heroicon-o-arrow-down-on-square')
                ->action(function (array $data) {
                    return response()->download(public_path('storage/qrcodes/' . $this->record->ref . '.svg'));
                })->color("success"),
            Actions\EditAction::make(),
        ];
    }
}
