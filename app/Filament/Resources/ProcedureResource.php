<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProcedureResource\Pages;
use App\Models\Procedure;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProcedureResource extends Resource
{
    protected static ?string $model = Procedure::class; // The model associated with this resource

    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $navigationGroupIcon = 'heroicon-o-cog'; // Add this line

    public static function getModelLabel(): string
    {
        return __('Procedures');
    }

    protected static ?string $navigationIcon = 'heroicon-o-document-text'; // Icon for the navigation sidebar

    protected static ?string $navigationLabel = 'Procedures'; // Label for the navigation sidebar

    protected static ?string $modelLabel = 'Procedure'; // Singular label for the resource



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Form fields for creating/editing a procedure
                Forms\Components\TextInput::make('procedure_name')
                    ->required()
                    ->maxLength(255)
                    ->label('Procedure Name'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Columns to display in the table
                Tables\Columns\TextColumn::make('procedure_id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('procedure_name')
                    ->label('Procedure Name')
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
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('Created From'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Created Until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
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




                // Delete action
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListProcedures::route('/'),
            //'create' => Pages\CreateProcedure::route('/create'),
            //'edit' => Pages\EditProcedure::route('/{record}/edit'),
            //'view' => Pages\ViewProcedure::route('/{record}/view'),
        ];
    }
}
