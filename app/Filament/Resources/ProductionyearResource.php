<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductionyearResource\Pages;
use App\Filament\Resources\ProductionyearResource\RelationManagers;
use App\Filament\Resources\ProductionyearResource\RelationManagers\VechilesRelationManager;
use App\Models\Productionyear;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductionyearResource extends Resource
{
    protected static ?string $model = Productionyear::class;

    protected static ?string $navigationIcon = 'vaadin-date-input';
    protected static ?string $navigationGroup = 'System Management';
    protected static ?string $navigationLabel = 'Tahun Produksi';
    protected static ?int $navigationSort = 3;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Select::make('type_id')
                            ->relationship('type', 'name')
                            ->required(),
                        
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('name')->label('Tahun')->sortable(),
                TextColumn::make('type.name')->label('Tipe')->sortable(),
                TextColumn::make('created_at')->dateTime()
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
            VechilesRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProductionyears::route('/'),
            'create' => Pages\CreateProductionyear::route('/create'),
            'edit' => Pages\EditProductionyear::route('/{record}/edit'),
        ];
    }    
}
