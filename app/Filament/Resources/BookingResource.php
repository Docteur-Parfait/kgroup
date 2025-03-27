<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Booking;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\Split;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use App\Filament\Resources\BookingResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BookingResource\RelationManagers;
use App\Filament\Resources\BookingResource\RelationManagers\ShipmentsRelationManager;
use Filament\Infolists\Components\TextEntry\TextEntrySize;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Gestion des expéditions';

    protected static ?string $navigationLabel = 'Booking';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('booking_number')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('ETD')->label("ETD")
                    ->maxLength(255),
                Forms\Components\TextInput::make('ETA')->label("ETA")
                    ->maxLength(255),
                Forms\Components\TextInput::make('POD')->label("POD")
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('booking_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ETD')->label("ETD")
                    ->searchable(),
                Tables\Columns\TextColumn::make('ETA')->label("ETA")
                    ->searchable(),
                Tables\Columns\TextColumn::make('POD')->label("POD")
                    ->searchable(),
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

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make("Booking info")
                    ->schema([
                        Split::make([
                            Grid::make(2)
                                ->schema([
                                    Group::make([
                                        TextEntry::make('booking_number')->weight(FontWeight::Bold)->size(TextEntrySize::Large),
                                        TextEntry::make('ETD')->label("ETD"),

                                    ]),
                                    Group::make([
                                        TextEntry::make('ETA')->label("ETA"),
                                        TextEntry::make('POD')->label("POD"),

                                    ]),
                                ]),

                        ])->from('lg'),
                    ]),




            ]);
    }


    public static function getRelations(): array
    {
        return [
            ShipmentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'view' => Pages\ViewBooking::route('/{record}'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}
