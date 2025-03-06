<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PatientResource\Pages;
use App\Models\Patient;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;

class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function getModelLabel(): string
    {
        return __('Patient');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Patients');
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('firstname')->label('First Name')->translateLabel()->required()->maxLength(191),
                        Forms\Components\TextInput::make('lastname')->label('Last Name')->translateLabel()->required()->maxLength(191),
                        Forms\Components\DatePicker::make('dob')->label('Date of Birth')->translateLabel()->required(),
                        Forms\Components\Select::make('gender')->label('Gender')->translateLabel()->options(['male' => 'Male', 'female' => 'Female', 'other' => 'Other'])->required(),
                        Forms\Components\TextInput::make('age')->label('Age')->translateLabel()->numeric()->required(),
                        Forms\Components\TextInput::make('location')->label('Location')->translateLabel()->required(),
                        Forms\Components\TextInput::make('phone_no')->label('Phone Number')->translateLabel()->required(),
                        Forms\Components\TextInput::make('email')->label('Email')->translateLabel()->email()->required(),
                        Forms\Components\TextInput::make('patient_no')->label('Patient Number')->translateLabel()->required(),
                        Forms\Components\Select::make('patient_status')->label('Patient Status')->translateLabel()->options(['active' => 'Active', 'inactive' => 'Inactive'])->required(),
                        Forms\Components\Select::make('cohort_id')->label('Cohort')->relationship('cohort', 'cohort_name')->required(),
                        Forms\Components\Select::make('branch_id')->label('Branch')->relationship('branch', 'branch_name')->required(),
                        Forms\Components\Select::make('diagnosis_id')->label('Diagnosis')->relationship('diagnosis', 'diagnosis_name')->required(),
                        Forms\Components\Select::make('scheme_id')->label('Scheme')->relationship('scheme', 'scheme_name')->required(),
                        Forms\Components\Select::make('route_id')->label('Route')->relationship('route', 'route_name')->required(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('firstname')->translateLabel(),
                Tables\Columns\TextColumn::make('lastname')->translateLabel(),
                Tables\Columns\TextColumn::make('dob')->translateLabel()->date(),
                Tables\Columns\TextColumn::make('gender')->translateLabel(),
                Tables\Columns\TextColumn::make('age')->translateLabel(),
                Tables\Columns\TextColumn::make('patient_no')->translateLabel(),
                Tables\Columns\TextColumn::make('patient_status')->translateLabel(),
            ])
            ->filters([
                SelectFilter::make('gender')->translateLabel()->options(['male' => 'Male', 'female' => 'Female', 'other' => 'Other']),
                SelectFilter::make('patient_status')->translateLabel()->options(['active' => 'Active', 'inactive' => 'Inactive']),
                Filter::make('created_at')
                    ->translateLabel()
                    ->form([
                        Forms\Components\DatePicker::make('created_from')->translateLabel(),
                        Forms\Components\DatePicker::make('created_until')->default(now())->translateLabel(),
                    ])
                    ->query(
                        fn(Builder $query, array $data): Builder =>
                        $query->when($data['created_from'], fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date))
                            ->when($data['created_until'], fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date))
                    ),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('asses')->url(fn(Patient $record) => static::getUrl('asses', ['record' => $record->patient_id])),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPatients::route('/'),
            'create' => Pages\CreatePatient::route('/create'),
            'edit' => Pages\EditPatient::route('/{record}/edit'),
            //'view' => Pages\ViewPatient::route('/{record}'),
            'asses' => Pages\ManagePatient::route('/{record}/asses'), // Ensure this route is define
        ];
    }
}
