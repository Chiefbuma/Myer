<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PhysiotherapyResource\Pages;
use App\Models\Physiotherapy;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PhysiotherapyResource extends Resource
{
    protected static ?string $model = Physiotherapy::class;
    protected static ?string $navigationIcon = 'heroicon-o-arrow-path';
    protected static ?string $navigationGroup = 'Reports';
    protected static ?string $modelLabel = 'Physiotherapy Report';
    protected static ?string $navigationLabel = 'Physiotherapy Reports';

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

                Forms\Components\DatePicker::make('visit_date')
                    ->required(),

                Forms\Components\TextInput::make('pain_level')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(10),

                Forms\Components\TextInput::make('mobility_score')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->suffix('%'),

                Forms\Components\TextInput::make('range_of_motion')
                    ->maxLength(255),

                Forms\Components\TextInput::make('strength')
                    ->maxLength(255),

                Forms\Components\TextInput::make('balance')
                    ->maxLength(255),

                Forms\Components\TextInput::make('walking_ability')
                    ->maxLength(255),

                Forms\Components\TextInput::make('posture_assessment')
                    ->maxLength(255),

                Forms\Components\TextInput::make('exercise_type')
                    ->maxLength(255),

                Forms\Components\TextInput::make('frequency_per_week')
                    ->numeric(),

                Forms\Components\TextInput::make('duration_per_session')
                    ->numeric()
                    ->suffix(' mins'),

                Forms\Components\TextInput::make('intensity')
                    ->maxLength(255),

                Forms\Components\TextInput::make('pain_level_before_exercise')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(10),

                Forms\Components\TextInput::make('pain_level_after_exercise')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(10),

                Forms\Components\TextInput::make('fatigue_level_before_exercise')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(10),

                Forms\Components\TextInput::make('fatigue_level_after_exercise')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(10),

                Forms\Components\TextInput::make('post_exercise_recovery_time')
                    ->numeric()
                    ->suffix(' mins'),

                Forms\Components\TextInput::make('functional_independence')
                    ->maxLength(255),

                Forms\Components\Toggle::make('joint_swelling'),

                Forms\Components\Toggle::make('muscle_spasms'),

                Forms\Components\TextInput::make('progress')
                    ->maxLength(255),

                Forms\Components\Textarea::make('treatment')
                    ->columnSpanFull(),

                Forms\Components\Textarea::make('challenges')
                    ->columnSpanFull(),

                Forms\Components\Textarea::make('adjustments_made')
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('calcium_levels')
                    ->numeric(),

                Forms\Components\TextInput::make('phosphorous_levels')
                    ->numeric(),

                Forms\Components\TextInput::make('vit_d_levels')
                    ->numeric(),

                Forms\Components\TextInput::make('cholesterol_levels')
                    ->numeric(),

                Forms\Components\TextInput::make('iron_levels')
                    ->numeric(),

                Forms\Components\TextInput::make('heart_rate')
                    ->numeric()
                    ->suffix(' bpm'),

                Forms\Components\TextInput::make('blood_pressure_systolic')
                    ->numeric(),

                Forms\Components\TextInput::make('blood_pressure_diastolic')
                    ->numeric(),

                Forms\Components\TextInput::make('oxygen_saturation')
                    ->numeric()
                    ->suffix('%'),

                Forms\Components\TextInput::make('hydration_level')
                    ->maxLength(255),

                Forms\Components\TextInput::make('sleep_quality')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(10),

                Forms\Components\TextInput::make('stress_level')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(10),

                Forms\Components\TextInput::make('medication_usage')
                    ->maxLength(255),

                Forms\Components\Textarea::make('therapist_notes')
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('revenue')
                    ->numeric()
                    ->prefix('KES'),
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
                    ->sortable(),

                Tables\Columns\TextColumn::make('scheme.scheme_name')
                    ->label('Scheme')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('visit_date')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('pain_level')
                    ->label('Pain Level')
                    ->numeric(),

                Tables\Columns\TextColumn::make('mobility_score')
                    ->label('Mobility Score')
                    ->suffix('%'),

                Tables\Columns\TextColumn::make('range_of_motion')
                    ->label('Range of Motion'),

                Tables\Columns\TextColumn::make('strength')
                    ->label('Strength'),

                Tables\Columns\TextColumn::make('balance')
                    ->label('Balance'),

                Tables\Columns\TextColumn::make('walking_ability')
                    ->label('Walking Ability'),

                Tables\Columns\TextColumn::make('posture_assessment')
                    ->label('Posture Assessment'),

                Tables\Columns\TextColumn::make('exercise_type')
                    ->label('Exercise Type'),

                Tables\Columns\TextColumn::make('frequency_per_week')
                    ->label('Frequency (per week)'),

                Tables\Columns\TextColumn::make('duration_per_session')
                    ->label('Duration/Session')
                    ->suffix(' mins'),

                Tables\Columns\TextColumn::make('intensity')
                    ->label('Intensity'),

                Tables\Columns\TextColumn::make('pain_level_before_exercise')
                    ->label('Pain Before Exercise'),

                Tables\Columns\TextColumn::make('pain_level_after_exercise')
                    ->label('Pain After Exercise'),

                Tables\Columns\TextColumn::make('fatigue_level_before_exercise')
                    ->label('Fatigue Before Exercise'),

                Tables\Columns\TextColumn::make('fatigue_level_after_exercise')
                    ->label('Fatigue After Exercise'),

                Tables\Columns\TextColumn::make('post_exercise_recovery_time')
                    ->label('Recovery Time')
                    ->suffix(' mins'),

                Tables\Columns\TextColumn::make('functional_independence')
                    ->label('Functional Independence'),

                Tables\Columns\IconColumn::make('joint_swelling')
                    ->label('Joint Swelling')
                    ->boolean(),

                Tables\Columns\IconColumn::make('muscle_spasms')
                    ->label('Muscle Spasms')
                    ->boolean(),

                Tables\Columns\TextColumn::make('progress')
                    ->label('Progress'),

                Tables\Columns\TextColumn::make('treatment')
                    ->label('Treatment')
                    ->wrap(),

                Tables\Columns\TextColumn::make('challenges')
                    ->label('Challenges')
                    ->wrap(),

                Tables\Columns\TextColumn::make('adjustments_made')
                    ->label('Adjustments Made')
                    ->wrap(),

                Tables\Columns\TextColumn::make('calcium_levels')
                    ->label('Calcium Levels'),

                Tables\Columns\TextColumn::make('phosphorous_levels')
                    ->label('Phosphorous Levels'),

                Tables\Columns\TextColumn::make('vit_d_levels')
                    ->label('Vitamin D Levels'),

                Tables\Columns\TextColumn::make('cholesterol_levels')
                    ->label('Cholesterol Levels'),

                Tables\Columns\TextColumn::make('iron_levels')
                    ->label('Iron Levels'),

                Tables\Columns\TextColumn::make('heart_rate')
                    ->label('Heart Rate')
                    ->suffix(' bpm'),

                Tables\Columns\TextColumn::make('blood_pressure_systolic')
                    ->label('BP Systolic'),

                Tables\Columns\TextColumn::make('blood_pressure_diastolic')
                    ->label('BP Diastolic'),

                Tables\Columns\TextColumn::make('oxygen_saturation')
                    ->label('Oxygen Saturation')
                    ->suffix('%'),

                Tables\Columns\TextColumn::make('hydration_level')
                    ->label('Hydration Level'),

                Tables\Columns\TextColumn::make('sleep_quality')
                    ->label('Sleep Quality'),

                Tables\Columns\TextColumn::make('stress_level')
                    ->label('Stress Level'),

                Tables\Columns\TextColumn::make('medication_usage')
                    ->label('Medication Usage'),

                Tables\Columns\TextColumn::make('therapist_notes')
                    ->label('Therapist Notes')
                    ->wrap(),

                Tables\Columns\TextColumn::make('revenue')
                    ->label('Revenue')
                    ->money('KES')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->dateTime(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('patient')
                    ->relationship('patient', 'patient_no')
                    ->searchable()
                    ->getOptionLabelFromRecordUsing(fn($record) => "{$record->firstname} {$record->lastname}"),

                Tables\Filters\SelectFilter::make('scheme')
                    ->relationship('scheme', 'scheme_name'),

                Tables\Filters\Filter::make('visit_date')
                    ->form([
                        Forms\Components\DatePicker::make('from'),
                        Forms\Components\DatePicker::make('until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('visit_date', '>=', $date),
                            )
                            ->when(
                                $data['until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('visit_date', '<=', $date),
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
            ->defaultSort('visit_date', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPhysiotherapies::route('/'),
            'create' => Pages\CreatePhysiotherapy::route('/create'),
            'edit' => Pages\EditPhysiotherapy::route('/{record}/edit'),
        ];
    }
}
