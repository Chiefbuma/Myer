<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MedicationUseResource\Pages;
use App\Models\Medication;
use App\Models\Patient;
use App\Models\MedicationUse;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MedicationUseResource extends Resource
{
    protected static ?string $model = MedicationUse::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-path';

    protected static ?string $navigationGroup = 'Reports';

    protected static ?string $modelLabel = 'Medication Use';

    protected static ?string $pluralModelLabel = 'Medication Uses';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('patient_id')
                    ->relationship('patient', 'patient_no')
                    ->getOptionLabelFromRecordUsing(fn($record) => "{$record->firstname} {$record->lastname} (ID: {$record->patient_no})")
                    ->searchable(['firstname', 'lastname', 'patient_no'])
                    ->required(),

                Forms\Components\Select::make('medication_id')
    ->relationship('medication', 'item_name') // Changed from 'name' to 'item_name'
    ->searchable()
    ->preload()
    ->required()
    ->label('Medication'),

                Forms\Components\DatePicker::make('visit_date')
                    ->required()
                    ->label('Visit Date')
                    ->default(now()),

                Forms\Components\TextInput::make('days_supplied')
                    ->numeric()
                    ->required()
                    ->label('Days Supplied'),

                Forms\Components\TextInput::make('no_pills_dispensed')
                    ->numeric()
                    ->required()
                    ->label('Number of Pills Dispensed'),

                Forms\Components\TextInput::make('frequency')
                    ->required()
                    ->label('Frequency (e.g., 2 times daily)'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->label('#')
                    ->rowIndex(),

                Tables\Columns\TextColumn::make('patient.full_name')
                    ->label('Patient')
                    ->formatStateUsing(fn($state, $record) => $record->patient->firstname . ' ' . $record->patient->lastname)
                    ->searchable(['patient.firstname', 'patient.lastname'])
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),

               Tables\Columns\TextColumn::make('medication.item_name')
    ->label('Medication')
    ->searchable()
    ->sortable()
    ->toggleable(isToggledHiddenByDefault: false),


                Tables\Columns\TextColumn::make('visit_date')
                    ->date()
                    ->sortable()
                    ->label('Visit Date')
                    ->toggleable(isToggledHiddenByDefault: false),

                Tables\Columns\TextColumn::make('days_supplied')
                    ->label('Days Supplied')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),

                Tables\Columns\TextColumn::make('no_pills_dispensed')
                    ->label('Pills Dispensed')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),

                Tables\Columns\TextColumn::make('frequency')
                    ->label('Frequency')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),

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
                Tables\Filters\SelectFilter::make('patient')
                    ->relationship('patient', 'patient_no')
                    ->getOptionLabelFromRecordUsing(fn($record) => "{$record->firstname} {$record->lastname} (ID: {$record->patient_no})")
                    ->searchable(['firstname', 'lastname', 'patient_no']),

                Tables\Filters\Filter::make('visit_date')
                    ->form([
                        Forms\Components\DatePicker::make('from_date')
                            ->label('From Date'),
                        Forms\Components\DatePicker::make('to_date')
                            ->label('To Date'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from_date'],
                                fn(Builder $query, $date): Builder => $query->whereDate('visit_date', '>=', $date),
                            )
                            ->when(
                                $data['to_date'],
                                fn(Builder $query, $date): Builder => $query->whereDate('visit_date', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('visit_date', 'desc')
            ->persistFiltersInSession();
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
            //'create' => Pages\CreateMedicationUse::route('/create'),
           // 'edit' => Pages\EditMedicationUse::route('/{record}/edit'),

        ];
    }
}
