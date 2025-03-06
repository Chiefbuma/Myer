<?php

namespace App\Filament\Resources\ChronicResource\Pages;

use App\Filament\Resources\ChronicResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListChronics extends ListRecords
{
    protected static string $resource = ChronicResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
