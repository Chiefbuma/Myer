<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SchemeResource\Pages;
use App\Models\Scheme;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SchemeResource extends Resource
{
    protected static ?string $model = Scheme::class; // The model associated with this resource

    protected static ?string $navigationIcon = 'heroicon-o-credit-card'; // Icon for the navigation sidebar

    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $navigationGroupIcon = 'heroicon-o-cog'; // Add this line

    protected static ?string $navigationLabel = 'Schemes'; // Label for the navigation sidebar

    protected static ?string $modelLabel = 'Scheme'; // Singular label for the resource


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Form fields for creating/editing a scheme
                Forms\Components\TextInput::make('scheme_name')
                    ->required()
                    ->maxLength(255)
                    ->label('Scheme Name'),

                Forms\Components\TextInput::make('payment_method')
                    ->required()
                    ->maxLength(255)
                    ->label('Payment Method'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Columns to display in the table
                Tables\Columns\TextColumn::make('scheme_id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('scheme_name')
                    ->label('Scheme Name')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Payment Method')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true), // Hidden by default

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true), // Hidden by default
            ])
            ->filters([
                // Filters for the table
                Tables\Filters\Filter::make('payment_method')
                    ->form([
                        Forms\Components\TextInput::make('payment_method')
                            ->label('Payment Method')
                            ->placeholder('Enter payment method'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['payment_method'],
                                fn(Builder $query, $value): Builder => $query->where('payment_method', 'like', "%{$value}%"),
                            );
                    }),
            ])
            ->actions([
                // Edit action in a modal
                Tables\Actions\EditAction::make()
                    ->modalHeading('Edit Procedure')
                    ->modalWidth('sm') // Adjust the modal width as needed
                    ->modalSubmitActionLabel('Save Changes')
                    ->slideOver(), // Open EditAction in a slide-over

                // View action in a modal
                Tables\Actions\ViewAction::make()
                    ->modalHeading('View Procedure')
                    ->modalWidth('sm') // Adjust the modal width as needed
                    ->slideOver(), // Open EditAction in a slide-over
            ])
            ->bulkActions([
                // Bulk actions
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(), // Bulk delete action
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Define relationships here (e.g., RelationManagers)
        ];
    }

    public static function getPages(): array
    {
        return [
            // Define pages for the resource
            'index' => Pages\ListSchemes::route('/'),
            // 'create' => Pages\CreateScheme::route('/create'),
            // 'edit' => Pages\EditScheme::route('/{record}/edit'),
        ];
    }
}
