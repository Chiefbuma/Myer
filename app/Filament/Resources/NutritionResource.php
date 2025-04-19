<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NutritionResource\Pages;
use App\Models\Nutrition;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class NutritionResource extends Resource
{
    protected static ?string $model = Nutrition::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationGroup = 'Reports';
    protected static ?string $modelLabel = 'Nutrition Report';
    protected static ?string $navigationLabel = 'Nutrition Reports';

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

                Forms\Components\DatePicker::make('last_visit'),

                Forms\Components\DatePicker::make('next_review'),

                Forms\Components\TextInput::make('muscle_mass')
                    ->numeric(),

                Forms\Components\TextInput::make('bone_mass')
                    ->numeric(),

                Forms\Components\TextInput::make('weight')
                    ->numeric()
                    ->suffix('kg'),

                Forms\Components\TextInput::make('BMI')
                    ->numeric()
                    ->label('BMI'),

                Forms\Components\TextInput::make('subcutaneous_fat')
                    ->numeric()
                    ->suffix('%'),

                Forms\Components\TextInput::make('visceral_fat')
                    ->numeric()
                    ->label('Visceral Fat Level'),

                Forms\Components\Textarea::make('weight_remarks')
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('physical_activity')
                    ->maxLength(255),

                Forms\Components\Toggle::make('meal_plan_set_up'),

                Forms\Components\TextInput::make('nutrition_adherence')
                    ->maxLength(255),

                Forms\Components\Textarea::make('nutrition_assessment_remarks')
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('revenue')
                    ->numeric()
                    ->prefix('KES'),

                Forms\Components\DatePicker::make('visit_date'),
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

                Tables\Columns\TextColumn::make('last_visit')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('next_review')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('weight')
                    ->suffix(' kg'),

                Tables\Columns\TextColumn::make('BMI')
                    ->label('BMI')
                    ->numeric(decimalPlaces: 1),

                Tables\Columns\TextColumn::make('subcutaneous_fat')
                    ->suffix('%'),

                Tables\Columns\TextColumn::make('visceral_fat')
                    ->label('Visceral Fat'),

                Tables\Columns\TextColumn::make('physical_activity')
                    ->limit(20)
                    ->tooltip(fn($record) => $record->physical_activity),

                Tables\Columns\IconColumn::make('meal_plan_set_up')
                    ->boolean(),

                Tables\Columns\TextColumn::make('nutrition_adherence')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Good' => 'success',
                        'Fair' => 'warning',
                        'Poor' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('revenue')
                    ->money('KES')
                    ->sortable(),

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
            'index' => Pages\ListNutrition::route('/'),
            //'create' => Pages\CreateNutrition::route('/create'),
            //'edit' => Pages\EditNutrition::route('/{record}/edit'),

        ];
    }
}
