<?php

namespace App\Filament\Resources\StepperResource\Pages;

use App\Filament\Resources\StepperResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageSteppers extends ManageRecords
{
    protected static string $resource = StepperResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
