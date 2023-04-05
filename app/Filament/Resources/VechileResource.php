<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VechileResource\Pages;
use App\Filament\Resources\VechileResource\RelationManagers;
use App\Models\Color;
use App\Models\Productionyear;
use App\Models\Type;
use App\Models\Brand;
use App\Models\Vechile;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
// use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VechileResource extends Resource
{
    protected static ?string $model = Vechile::class;

    protected static ?string $navigationIcon = 'vaadin-car';

    protected static ?string $navigationLabel = 'Kendaraan';

    protected static ?string $navigationGroup = 'Service Management';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Select::make('brand_id')
                            ->label('Model')
                            ->options(Brand::all()->pluck('name', 'id')->toArray())
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(fn (callable $set) => $set('type_id', null)),

                        Select::make('type_id')
                            ->label('Tipe')
                            ->required()
                            ->options(function (callable $get) {
                                $brand = Brand::find($get('brand_id'));
                                if (!$brand) {
                                    return Type::all()->pluck('name', 'id');
                                }
                                return $brand->types->pluck('name', 'id');

                            })
                            ->reactive()
                            ->afterStateUpdated(fn (callable $set) => $set('productionyear_id', null)),

                        Select::make('productionyear_id')
                            ->label('Tahun Produksi')
                            ->options(function (callable $get) {
                                $type = Type::find($get('type_id'));
                                if (!$type) {
                                    return Productionyear::all()->pluck('name', 'id');
                                }
                                return $type->productionyears->pluck('name', 'id');
                            })
                            ->required()
                            ->reactive(),

                        Select::make('color_id')
                            ->label('Warna')
                            ->options(function (callable $get) {
                                $type = Type::find($get('type_id'));
                                if (!$type) {
                                    return Color::all()->pluck('name', 'id');
                                }
                                return $type->colors->pluck('name', 'id');
                            })
                            ->required()
                            ->reactive(),

                        TextInput::make('police_num')->required()->maxLength(255),
                        TextInput::make('chassis_num')->required()->maxLength(255),
                        DatePicker::make('expiry_date_stnk')->required(),

                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('brand.name')->label('model')->sortable()->searchable(),
                TextColumn::make('type.name')->label('tipe')->sortable()->searchable(),
                TextColumn::make('productionyear.name')->label('tahun produksi')->sortable()->searchable(),
                TextColumn::make('color.name')->label('warna')->sortable()->searchable(),
                TextColumn::make('police_num')->sortable(),
                TextColumn::make('chassis_num')->sortable(),
                TextColumn::make('expiry_date_stnk')->date(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
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
            'index' => Pages\ListVechiles::route('/'),
            'create' => Pages\CreateVechile::route('/create'),
            'edit' => Pages\EditVechile::route('/{record}/edit'),
        ];
    }    
}
