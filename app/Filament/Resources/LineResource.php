<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LineResource\Pages;
use App\Filament\Resources\LineResource\RelationManagers;
use App\Models\Line;
use App\Models\TransportMode;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LineResource extends Resource
{
    protected static ?string $model = Line::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    protected static ?string $navigationGroup = 'Configuration';

    protected static ?string $navigationLabel = 'Gestion des lignes';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('departure_country_id')
                    ->relationship('departureCountry', 'name')
                    ->required(),
                Forms\Components\Select::make('arrival_country_id')
                    ->relationship('arrivalCountry', 'name')
                    ->required(),
                Forms\Components\Toggle::make('ramassage')
                    ->label('Ramassage autorisé')
                    ->default(false),

                Forms\Components\Repeater::make('prices')
                    ->schema([
                        Forms\Components\Select::make('transport_mode')->label("Mode de transport")
                            ->options(transportationMode())
                            ->required(),
                        Forms\Components\Select::make('devise')
                            ->options([
                                'EUR' => 'Euro',
                                'USD' => 'Dollar Américain',
                                'XOF' => 'CFA',
                                "CAD" => "Dollar Canadien",
                            ]),
                        Forms\Components\TextInput::make('price')->label("Prix pas kilo")
                            ->numeric(),
                        // Forms\Components\TextInput::make('per')
                        //     ->required()
                        //     ->placeholder('ex: par personne, par kilo...')
                    ])
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageLines::route('/'),
        ];
    }
}
