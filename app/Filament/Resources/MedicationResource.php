<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MedicationResource\Pages;
use App\Models\Medication;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MedicationResource extends Resource
{
    protected static ?string $model = Medication::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text'; // Use an appropriate icon

    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $navigationGroupIcon = 'heroicon-o-cog'; // Add this line

    public static function form(Form $form): Form
    {
        return $form
            ->schema([


                Forms\Components\TextInput::make('item_name')
                    ->label('Item Name')
                    ->required()
                    ->maxLength(191)

                    ->mutateDehydratedStateUsing(fn($state) => strtoupper($state)), // Convert to uppercase before saving

                Forms\Components\Textarea::make('composition')
                    ->label('Composition')
                    ->nullable()
                    ->columnSpanFull(),

                Forms\Components\Select::make('brand')
                    ->label('Brand')
                    ->required()
                    ->options([
                        'original' => 'Original',
                        'generic' => 'Generic',
                    ]),

                Forms\Components\Select::make('formulation')
                    ->label('Formulation')
                    ->required()
                    ->options([
                        'Tablet' => 'Tablet',
                        'Capsule' => 'Capsule',
                        'Inhaler' => 'Inhaler',
                        'Injection' => 'Injection',
                    ]),

                Forms\Components\Select::make('category')
                    ->label('Category')
                    ->required()
                    ->options([
                        'Diabetes Care' => 'Diabetes Care',
                        'Oncology Drugs' => 'Oncology Drugs',
                        'Cardiovascular' => 'Cardiovascular',
                        'Men\'s Health' => 'Men\'s Health',
                        'Post-Transplant Medications' => 'Post-Transplant Medications',
                        'Renal' => 'Renal',
                    ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('medication_id')
                    ->label('Medication ID')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('item_name')
                    ->label('Item Name')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('brand')
                    ->label('Brand')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('formulation')
                    ->label('Formulation')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('category')
                    ->label('Category')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Add filters here if needed
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->slideOver(), // Open EditAction in a slide-over

                Tables\Actions\ViewAction::make()
                    ->slideOver(), // Open ViewAction in a slide-over
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
            // Add relations here if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMedications::route('/'),
            //'create' => Pages\CreateMedication::route('/create'),
            // 'edit' => Pages\EditMedication::route('/{record}/edit'),
            // 'view' => Pages\ViewMedication::route('/{record}/view'),
        ];
    }
}
