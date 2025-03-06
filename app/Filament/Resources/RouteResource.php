<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RouteResource\Pages;
use App\Models\Route;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Database\Eloquent\Builder;

class RouteResource extends Resource
{
    protected static ?string $model = Route::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';

    protected static ?string $navigationLabel = 'Routes';

    protected static ?string $modelLabel = 'Route';

    protected static ?string $navigationGroup = 'Settings';

    protected static ?string $navigationGroupIcon = 'heroicon-o-cog'; // Add this line

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('route_name')
                ->required()
                ->maxLength(255)
                ->label('Route Name'),

            Forms\Components\TextInput::make('latitude')
                ->required()
                ->numeric()
                ->label('Latitude'),

            Forms\Components\TextInput::make('longitude')
                ->required()
                ->numeric()
                ->label('Longitude'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('route_id')
                ->label('ID')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('route_name')
                ->label('Route Name')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('latitude')
                ->label('Latitude')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('longitude')
                ->label('Longitude')
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
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([  // 🔹 Keeping only "Search Place"
                Tables\Actions\Action::make('searchPlace')
                    ->label('Search Place')
                    ->modalHeading('Search Place')
                    ->modalWidth('sm')
                    ->form([
                        Forms\Components\Select::make('place')
                            ->label('Select a location')
                            ->searchable()
                            ->reactive()
                            ->getSearchResultsUsing(fn(string $query) => self::fetchLocationSuggestions($query))
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                $selectedPlace = json_decode($state, true);
                                if (json_last_error() === JSON_ERROR_NONE) {
                                    $set('latitude', $selectedPlace['lat']);
                                    $set('longitude', $selectedPlace['lon']);
                                }
                            }),

                        Forms\Components\TextInput::make('latitude')
                            ->label('Latitude')
                            ->disabled(),

                        Forms\Components\TextInput::make('longitude')
                            ->label('Longitude')
                            ->disabled(),

                        Forms\Components\TextInput::make('route_name')
                            ->label('Route Name')
                            ->required(),
                    ])
                    ->action(function (array $data) {
                        $selectedPlace = json_decode($data['place'], true);
                        if (json_last_error() !== JSON_ERROR_NONE) {
                            throw new \Exception('Invalid place data');
                        }

                        Route::create([
                            'route_name' => $data['route_name'],
                            'latitude' => $selectedPlace['lat'],
                            'longitude' => $selectedPlace['lon'],
                        ]);
                    }),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRoutes::route('/'),
        ];
    }

    protected static function fetchLocationSuggestions(string $query): array
    {
        if (empty($query)) {
            return [];
        }

        try {
            $client = new Client([
                'headers' => [
                    'User-Agent' => 'MyFilamentApp/1.0 (myemail@example.com)',
                ],
            ]);

            $url = "https://nominatim.openstreetmap.org/search?format=json&q=" . urlencode($query);
            $response = $client->get($url);

            if ($response->getStatusCode() !== 200) {
                return [];
            }

            $data = json_decode($response->getBody(), true);
            $options = [];

            foreach ($data as $item) {
                $options[json_encode([
                    'lat' => $item['lat'],
                    'lon' => $item['lon'],
                    'name' => $item['display_name'],
                ])] = $item['display_name'];
            }

            return $options;
        } catch (RequestException $e) {
            return [];
        }
    }
}
