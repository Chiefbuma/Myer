<?php

namespace App\Filament\Resources\PhysiotherapyResource\Pages;

use App\Filament\Resources\PhysiotherapyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPhysiotherapies extends ListRecords
{
    protected static string $resource = PhysiotherapyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
