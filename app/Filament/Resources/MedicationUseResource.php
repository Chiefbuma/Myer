<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MedicationUseResource\Pages;
use App\Filament\Resources\MedicationUseResource\RelationManagers;
use App\Models\MedicationUse;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MedicationUseResource extends Resource
{
    protected static ?string $model = MedicationUse::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // Add navigation group
    protected static ?string $navigationGroup = 'Reports';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMedicationUses::route('/'),
            // 'create' => Pages\CreateMedicationUse::route('/create'),
            //'edit' => Pages\EditMedicationUse::route('/{record}/edit'),
            // 'view' => Pages\ViewMedicationUse::route('/{record}/view'),

        ];
    }
}
