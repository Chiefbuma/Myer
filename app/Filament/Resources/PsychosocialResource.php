<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PsychosocialResource\Pages;
use App\Models\Psychosocial;
use App\Models\Scheme;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PsychosocialResource extends Resource
{
    protected static ?string $model = Psychosocial::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Reports';
    protected static ?string $modelLabel = 'Psychosocial Assessment';
    protected static ?string $pluralModelLabel = 'Psychosocial Assessments';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Patient Information')
                    ->schema([
                        Forms\Components\Select::make('patient_id')
                            ->relationship('patient', 'patient_no')
                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->firstname} {$record->lastname} (ID: {$record->patient_no})")
                            ->searchable(['firstname', 'lastname', 'patient_no'])
                            ->required(),
                    ]),

                Forms\Components\Section::make('Assessment Dates')
                    ->schema([
                        Forms\Components\DatePicker::make('last_visit')
                            ->required(),
                        Forms\Components\DatePicker::make('next_review')
                            ->required(),
                        Forms\Components\DatePicker::make('visit_date')
                            ->required()
                            ->default(now()),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Personal Information')
                    ->schema([
                        Forms\Components\Select::make('educational_level')
                            ->options([
                                'none' => 'None',
                                'primary' => 'Primary',
                                'secondary' => 'Secondary',
                                'tertiary' => 'Tertiary',
                            ]),
                        Forms\Components\Select::make('career_business')
                            ->options([
                                'employed' => 'Employed',
                                'self_employed' => 'Self Employed',
                                'unemployed' => 'Unemployed',
                            ]),
                        Forms\Components\Select::make('marital_status')
                            ->options([
                                'single' => 'Single',
                                'married' => 'Married',
                                'divorced' => 'Divorced',
                            ]),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Relationship Status')
                    ->schema([
                        Forms\Components\Select::make('relationship_status')
                            ->options([
                                'stable' => 'Stable',
                                'unstable' => 'Unstable',
                                'none' => 'None',
                            ]),
                        Forms\Components\Select::make('primary_relationship_status')
                            ->options([
                                'healthy' => 'Healthy',
                                'strained' => 'Strained',
                                'conflict' => 'Conflict',
                            ]),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Personal Development')
                    ->schema([
                        Forms\Components\Select::make('ability_to_enjoy_leisure_activities')
                            ->options([
                                'good' => 'Good',
                                'fair' => 'Fair',
                                'poor' => 'Poor',
                            ]),
                        Forms\Components\Select::make('spirituality')
                            ->options([
                                'important' => 'Important',
                                'somewhat' => 'Somewhat Important',
                                'not' => 'Not Important',
                            ]),
                        Forms\Components\Select::make('level_of_self_esteem')
                            ->options([
                                'high' => 'High',
                                'moderate' => 'Moderate',
                                'low' => 'Low',
                            ]),
                        Forms\Components\Select::make('sex_life')
                            ->options([
                                'satisfactory' => 'Satisfactory',
                                'unsatisfactory' => 'Unsatisfactory',
                            ]),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Coping Skills')
                    ->schema([
                        Forms\Components\Select::make('ability_to_cope_recover_disappointments')
                            ->options([
                                'excellent' => 'Excellent',
                                'good' => 'Good',
                                'poor' => 'Poor',
                            ]),
                        Forms\Components\Select::make('rate_of_personal_development_growth')
                            ->options([
                                'excellent' => 'Excellent',
                                'good' => 'Good',
                                'poor' => 'Poor',
                            ]),
                        Forms\Components\Select::make('achievement_of_balance_in_life')
                            ->options([
                                'balanced' => 'Balanced',
                                'unbalanced' => 'Unbalanced',
                            ]),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Support System')
                    ->schema([
                        Forms\Components\Select::make('social_support_system')
                            ->options([
                                'strong' => 'Strong',
                                'adequate' => 'Adequate',
                                'weak' => 'Weak',
                            ]),
                        Forms\Components\Select::make('substance_use')
                            ->options([
                                'none' => 'None',
                                'occasional' => 'Occasional',
                                'regular' => 'Regular',
                            ]),
                        Forms\Components\Select::make('substance_used')
                            ->options([
                                'alcohol' => 'Alcohol',
                                'tobacco' => 'Tobacco',
                                'other' => 'Other',
                            ])
                            ->multiple(),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Remarks & Financial')
                    ->schema([
                        Forms\Components\Textarea::make('assessment_remarks')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('revenue')
                            ->numeric(),
                        Forms\Components\Select::make('scheme_id')
                            ->relationship('scheme', 'scheme_name'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('patient.full_name')
                    ->label('Patient')
                    ->formatStateUsing(fn($state, $record) => $record->patient->firstname . ' ' . $record->patient->lastname)
                    ->searchable(['patient.firstname', 'patient.lastname'])
                    ->sortable(),

                Tables\Columns\TextColumn::make('last_visit')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('next_review')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('educational_level')
                    ->label('Education')
                    ->badge(),

                Tables\Columns\TextColumn::make('career_business')
                    ->label('Career')
                    ->badge(),

                Tables\Columns\TextColumn::make('marital_status')
                    ->label('Marital Status')
                    ->badge(),

                Tables\Columns\TextColumn::make('relationship_status')
                    ->label('Relationship')
                    ->badge(),

                Tables\Columns\TextColumn::make('primary_relationship_status')
                    ->label('Primary Relationship')
                    ->badge(),

                Tables\Columns\TextColumn::make('ability_to_enjoy_leisure_activities')
                    ->label('Leisure')
                    ->badge(),

                Tables\Columns\TextColumn::make('spirituality')
                    ->badge(),

                Tables\Columns\TextColumn::make('level_of_self_esteem')
                    ->label('Self Esteem')
                    ->badge(),

                Tables\Columns\TextColumn::make('sex_life')
                    ->label('Sex Life')
                    ->badge(),

                Tables\Columns\TextColumn::make('ability_to_cope_recover_disappointments')
                    ->label('Coping Ability')
                    ->badge(),

                Tables\Columns\TextColumn::make('rate_of_personal_development_growth')
                    ->label('Growth Rate')
                    ->badge(),

                Tables\Columns\TextColumn::make('achievement_of_balance_in_life')
                    ->label('Life Balance')
                    ->badge(),

                Tables\Columns\TextColumn::make('social_support_system')
                    ->label('Support System')
                    ->badge(),

                Tables\Columns\TextColumn::make('substance_use')
                    ->label('Substance Use')
                    ->badge(),

                Tables\Columns\TextColumn::make('substance_used')
                    ->label('Substances Used')
                    ->badge(),

                Tables\Columns\TextColumn::make('assessment_remarks')
                    ->label('Remarks')
                    ->limit(30)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        return strlen($state) <= 30 ? null : $state;
                    }),

                Tables\Columns\TextColumn::make('revenue')
                    ->money(),

                Tables\Columns\TextColumn::make('scheme.scheme_name')
                    ->label('Scheme'),

                Tables\Columns\TextColumn::make('visit_date')
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
                Tables\Filters\SelectFilter::make('marital_status')
                    ->options([
                        'single' => 'Single',
                        'married' => 'Married',
                        'divorced' => 'Divorced',
                    ]),

                Tables\Filters\SelectFilter::make('educational_level')
                    ->options([
                        'none' => 'None',
                        'primary' => 'Primary',
                        'secondary' => 'Secondary',
                    ]),

                Tables\Filters\Filter::make('visit_date')
                    ->form([
                        Forms\Components\DatePicker::make('from_date'),
                        Forms\Components\DatePicker::make('to_date'),
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
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('visit_date', 'desc')
            ->persistFiltersInSession()
            ->deferLoading();
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
        ];
    }
}
