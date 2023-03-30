<?php

namespace App\Filament\Resources\ColorResource\RelationManagers;

use App\Models\Type;
use App\Models\Brand;
use App\Models\Productionyear;
use App\Models\Color;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VechilesRelationManager extends RelationManager
{
    protected static string $relationship = 'vechiles';

    protected static ?string $recordTitleAttribute = 'police_num';

    public static function form(Form $form): Form
    {
        return $form
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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('type_id')->sortable(),
                TextColumn::make('productionyear_id')->sortable()->searchable(),
                TextColumn::make('color_id')->sortable()->searchable(),
                TextColumn::make('police_num'),
                TextColumn::make('chassis_num'),
                TextColumn::make('expiry_date_stnk')->date(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
