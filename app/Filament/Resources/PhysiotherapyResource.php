<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PhysiotherapyResource\Pages;
use App\Filament\Resources\PhysiotherapyResource\RelationManagers;
use App\Models\Physiotherapy;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PhysiotherapyResource extends Resource
{
    protected static ?string $model = Physiotherapy::class;

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
            'index' => Pages\ListPhysiotherapies::route('/'),
            'create' => Pages\CreatePhysiotherapy::route('/create'),
            'edit' => Pages\EditPhysiotherapy::route('/{record}/edit'),
            //'view' => Pages\ViewPhysiotherapy::route('/{record}/view'),
            //'manage' => Pages\ManagePhysiotherapy::route('/{record}/manage'),
        ];
    }
}
