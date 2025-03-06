<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PsychosocialResource\Pages;
use App\Filament\Resources\PsychosocialResource\RelationManagers;
use App\Models\Psychosocial;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PsychosocialResource extends Resource
{
    protected static ?string $model = Psychosocial::class;

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
            'index' => Pages\ListPsychosocials::route('/'),
            'create' => Pages\CreatePsychosocial::route('/create'),
            'edit' => Pages\EditPsychosocial::route('/{record}/edit'),
            //'view' => Pages\ViewPsychosocial::route('/{record}/view'),
            //'manage' => Pages\ManagePsychosocial::route('/{record}/manage'),
        ];
    }
}
