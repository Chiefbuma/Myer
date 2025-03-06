<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SpecialistResource\Pages;
use App\Models\Specialist;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SpecialistResource extends Resource
{
    protected static ?string $model = Specialist::class;

    protected static ?string $navigationGroup = 'Settings';

    protected static ?string $navigationGroupIcon = 'heroicon-o-cog'; // Add this line




    public static function getModelLabel(): string
    {
        return __('Specialist');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Specialists');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('specialist_name')
                    ->label('Specialist Name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('specialty')
                    ->label('Specialty')
                    ->required()
                    ->maxLength(255),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('specialist_id')
                    ->label('ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('specialist_name')
                    ->label('Name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('specialty')
                    ->label('Specialty')
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSpecialists::route('/'),
            // 'create' => Pages\CreateSpecialist::route('/create'),
            // 'edit' => Pages\EditSpecialist::route('/{record}/edit'),
        ];
    }
}
