<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Columns\NumberColumn;
use Filament\Tables\Table;
use App\Models\PedidosDetalle;
use App\Models\pedidos_detalle;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\Summarizers\Sum;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PedidosDetalleResource\Pages;
use App\Filament\Resources\PedidosDetalleResource\RelationManagers;

class PedidosDetalleResource extends Resource
{
    protected static ?string $model = pedidos_detalle::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pedido_id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('producto.nombre')
                    ->sortable(),
                Tables\Columns\TextColumn::make('pedido.compra.id')
                    ->sortable(),
                //TextColumn::make('cantidad')->label('Cantidad')->sum(),
                
                Tables\Columns\TextColumn::make('pedido.compra.titulo')
                    ->sortable(),
                Tables\Columns\TextColumn::make('cantidad')
                    ->sortable()
                    ->summarize(Sum::make())
            ])
            ->filters([
                SelectFilter::make('pedido')
                    ->multiple()
                    ->relationship('pedido', 'id')
                    //->searchable()
                    ->preload(),
                SelectFilter::make('pedido.compra')
                    ->label('Compra')
                    ->multiple()
                    ->relationship('pedido.compra', 'id',)
                    //->searchable()
                    ->preload()
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->groups([
                'producto.nombre',
                
            ])
            ->defaultGroup('producto.nombre');
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
            'index' => Pages\ListPedidosDetalles::route('/'),
            'create' => Pages\CreatePedidosDetalle::route('/create'),
            'edit' => Pages\EditPedidosDetalle::route('/{record}/edit'),
        ];
    }
}
