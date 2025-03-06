<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NutritionResource\Pages;
use App\Filament\Resources\NutritionResource\RelationManagers;
use App\Models\Nutrition;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NutritionResource extends Resource
{
    protected static ?string $model = Nutrition::class;

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
                //
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
            'index' => Pages\ListNutrition::route('/'),
            'create' => Pages\CreateNutrition::route('/create'),
            'edit' => Pages\EditNutrition::route('/{record}/edit'),
        ];
    }
}
