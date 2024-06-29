<?php

namespace App\Filament\Resources;

use App\Enums\Estado;
use Filament\Forms;
use Filament\Tables;
use App\Models\Compra;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ComprasResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ComprasResource\RelationManagers\PedidosRelationManager;

class ComprasResource extends Resource
{
    protected static ?string $model = Compra::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('titulo')
                    ->disabledOn('edit')
                    ->required(),
                Forms\Components\TextInput::make('descripcion')
                    ->disabledOn('edit')
                    ->required(),
                Forms\Components\DatePicker::make('fecha_compra')
                    ->disabledOn('edit')
                    ->required(),
                Forms\Components\Select::make('estado')
                    ->options(Estado::class)
                    ->required(),
            ])
            ;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Split::make([
                    Tables\Columns\TextColumn::make('titulo')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('descripcion')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('fecha_compra')
                        ->date()
                        ->sortable(),
                    Tables\Columns\TextColumn::make('estado')
                        //->options(Estado::class),
                        //->hiddenFrom('sm'),
                    ,
                    Tables\Columns\TextColumn::make('created_at')
                        ->dateTime()
                        ->sortable()
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->hiddenFrom('sm'),
                    Tables\Columns\TextColumn::make('updated_at')
                        ->dateTime()
                        ->sortable()
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->hiddenFrom('sm'),
                ])->from('md')
            ])
            ->filters([
                //
            ])
            ->actions([
                //Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            PedidosRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCompras::route('/'),
            'create' => Pages\CreateCompras::route('/create'),
            'edit' => Pages\EditCompras::route('/{record}/edit'),
            'view' => Pages\ViewCompras::route('/{record}/view'),
        ];
    }
}
