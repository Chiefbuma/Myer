<?php

namespace App\Filament\Resources\PsychosocialResource\Pages;

use App\Filament\Resources\PsychosocialResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPsychosocials extends ListRecords
{
    protected static string $resource = PsychosocialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
