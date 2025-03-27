<?php

namespace App\Filament\Resources\PubResource\Pages;

use App\Filament\Resources\PubResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePubs extends ManageRecords
{
    protected static string $resource = PubResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
