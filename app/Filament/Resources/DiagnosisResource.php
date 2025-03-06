<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DiagnosisResource\Pages;
use App\Models\Diagnosis;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Log;

class DiagnosisResource extends Resource
{
    protected static ?string $model = Diagnosis::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $navigationGroupIcon = 'heroicon-o-cog'; // Add this line

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Diagnosis Name Field (Searchable Select)
                Forms\Components\Select::make('diagnosis_name')
                    ->label('Diagnosis Name')
                    ->required()
                    ->searchable()
                    ->getSearchResultsUsing(function (string $search) {
                        // Fetch suggestions from the API based on the search query
                        $suggestions = self::fetchICD10Data($search);

                        // Format the suggestions as "ICD-10 Code - Diagnosis Name"
                        return collect($suggestions)->mapWithKeys(function ($name, $code) {
                            $concatenatedValue = "{$code} - {$name}";
                            return [$concatenatedValue => $concatenatedValue]; // Use concatenated value as both key and value
                        })->toArray();
                    })
                    ->getOptionLabelUsing(function ($value) {
                        // Display the selected option label
                        return $value; // The value is already in the format "ICD-10 Code - Diagnosis Name"
                    }),
            ]);
    }

    /**
     * Fetch ICD-10 data from the API.
     *
     * @param string $query The search query.
     * @return array An associative array of ICD-10 codes and diagnosis names.
     */
    protected static function fetchICD10Data(string $query): array
    {
        $url = "https://clinicaltables.nlm.nih.gov/api/icd10cm/v3/search?sf=code,name&terms=" . urlencode($query);

        try {
            $response = file_get_contents($url);
            $data = json_decode($response, true);

            if (isset($data[3]) && count($data[3]) > 0) {
                // Return an associative array of ICD-10 codes and diagnosis names
                return array_combine(
                    array_column($data[3], 0),  // ICD-10 codes as keys
                    array_column($data[3], 1)   // Diagnosis names as values
                );
            }
        } catch (\Exception $e) {
            Log::error('ICD-10 API Fetch Error:', ['error' => $e->getMessage()]);
        }

        return [];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('diagnosis_name')
                    ->label('Diagnosis Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable(),
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
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDiagnoses::route('/'),
            //'create' => Pages\CreateDiagnosis::route('/create'),
            //'edit' => Pages\EditDiagnosis::route('/{record}/edit'),
            // 'view' => Pages\ViewDiagnosis::route('/{record}/view'),
        ];
    }
}
