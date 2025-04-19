<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChronicResource\Pages;
use App\Models\Chronic;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ChronicResource extends Resource
{
    protected static ?string $model = Chronic::class;
    protected static ?string $navigationIcon = 'heroicon-o-heart';
    protected static ?string $navigationGroup = 'Reports';
    protected static ?string $modelLabel = 'Chronic Care';
    protected static ?string $navigationLabel = 'Chronic Care Reports';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('patient_id')
                    ->relationship('patient', 'patient_no')
                    ->getOptionLabelFromRecordUsing(fn($record) => "{$record->firstname} {$record->lastname} (ID: {$record->patient_no})")
                    ->searchable(['firstname', 'lastname', 'patient_no'])
                    ->required(),

                Forms\Components\Select::make('scheme_id')
                    ->relationship('scheme', 'scheme_name')
                    ->required(),

                Forms\Components\Select::make('procedure_id')
                    ->relationship('procedure', 'procedure_name'),

                Forms\Components\Select::make('speciality_id')
                    ->relationship('speciality', 'specialist_name'),

                Forms\Components\DatePicker::make('refill_date')
                    ->required(),

                Forms\Components\TextInput::make('compliance')
                    ->maxLength(255),

                Forms\Components\TextInput::make('exercise')
                    ->maxLength(255),

                Forms\Components\Textarea::make('clinical_goals')
                    ->columnSpanFull(),

                Forms\Components\Toggle::make('nutrition_follow_up'),

                Forms\Components\TextInput::make('psychosocial')
                    ->maxLength(255),

                Forms\Components\Toggle::make('annual_check_up'),

                Forms\Components\Toggle::make('specialist_review'),

                Forms\Components\Toggle::make('vitals_monitoring'),

                Forms\Components\TextInput::make('revenue')
                    ->numeric(),

                Forms\Components\TextInput::make('vital_signs_monitor')
                    ->maxLength(255),

                Forms\Components\DatePicker::make('last_visit'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->label('#')
                    ->rowIndex(),  // This adds automatic row numbering

                Tables\Columns\TextColumn::make('patient.full_name')
                    ->label('Patient')
                    ->formatStateUsing(fn($state, $record) => $record->patient->firstname . ' ' . $record->patient->lastname)
                    ->searchable(['patient.firstname', 'patient.lastname'])
                    ->sortable(),

                Tables\Columns\TextColumn::make('scheme.scheme_name')
                    ->label('Scheme')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('procedure.procedure_name')
                    ->label('Procedure'),

                Tables\Columns\TextColumn::make('speciality.specialist_name')
                    ->label('Speciality'),

                Tables\Columns\TextColumn::make('refill_date')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('compliance'),

                Tables\Columns\TextColumn::make('exercise'),

                Tables\Columns\TextColumn::make('clinical_goals')
                    ->limit(30)
                    ->tooltip(fn($record) => $record->clinical_goals),

                Tables\Columns\IconColumn::make('nutrition_follow_up')
                    ->boolean(),

                Tables\Columns\TextColumn::make('psychosocial'),

                Tables\Columns\IconColumn::make('annual_check_up')
                    ->boolean(),

                Tables\Columns\IconColumn::make('specialist_review')
                    ->boolean(),

                Tables\Columns\IconColumn::make('vitals_monitoring')
                    ->boolean(),

                Tables\Columns\TextColumn::make('revenue')
                    ->money('KES')
                    ->sortable(),

                Tables\Columns\TextColumn::make('vital_signs_monitor'),

                Tables\Columns\TextColumn::make('last_visit')
                    ->date()
                    ->sortable(),

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
                    ->searchable()
                    ->getOptionLabelFromRecordUsing(fn($record) => "{$record->firstname} {$record->lastname}"),

                Tables\Filters\SelectFilter::make('scheme')
                    ->relationship('scheme', 'scheme_name'),

                Tables\Filters\SelectFilter::make('procedure')
                    ->relationship('procedure', 'procedure_name'),

                Tables\Filters\Filter::make('last_visit')
                    ->form([
                        Forms\Components\DatePicker::make('from'),
                        Forms\Components\DatePicker::make('until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('last_visit', '>=', $date),
                            )
                            ->when(
                                $data['until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('last_visit', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('last_visit', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListChronics::route('/'),
            //'create' => Pages\CreateChronic::route('/create'),
            //'edit' => Pages\EditChronic::route('/{record}/edit'),

        ];
    }
}
