<?php

namespace App\Filament\Resources\VechileResource\Pages;

use App\Filament\Resources\VechileResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVechiles extends ListRecords
{
    protected static string $resource = VechileResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
