<?php

namespace App\Filament\Resources\VechileResource\Pages;

use App\Filament\Resources\VechileResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVechile extends EditRecord
{
    protected static string $resource = VechileResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
