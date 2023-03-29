<?php

namespace App\Filament\Resources\ProductionyearResource\Pages;

use App\Filament\Resources\ProductionyearResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProductionyear extends EditRecord
{
    protected static string $resource = ProductionyearResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
