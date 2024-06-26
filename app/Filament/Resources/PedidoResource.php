<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Compra;
use App\Models\Pedido;
use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Models\Producto;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Actions\BulkAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\CreateAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use App\Filament\Resources\PedidoResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PedidoResource\RelationManagers;

class PedidoResource extends Resource
{
    protected static ?string $model = pedido::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Forms\Components\Select::make('compra_id')
                    ->native(false)
                    ->live()
                    ->relationship(
                        name: 'compra',
                        titleAttribute: 'titulo',
                        modifyQueryUsing: function (Builder $query) {
                            return $query->where('estado','Abierta');
                        })
                    
                    //->virtualAs('concat(titulo, \' \', descripcion)')
                    //->searchable()
                    ->placeholder('Seleccione en que compra quiere realizar su pedido')
                    ->getOptionLabelUsing(fn ($value): ?string => '')
                    ->required(),
                Placeholder::make('InfoCompra')
                    ->content(function (Get $get, Set $set): string {
                        $compra = Compra::find($get('compra_id'));
                        
                        return $compra?->descripcion .' - '. $compra?->fecha_compra ?? '';
                    }),
                Forms\Components\TextInput::make('Observaciones')
                    ->placeholder('Acá podés agregar un compentario sobre tu pedido'),
                Repeater::make('pedidos_detalles')
                    ->addActionLabel('Agregar producto')
                    ->label('Productos')
                    ->relationship()
                    ->schema([
                        Select::make('producto_id')
                            ->afterStateUpdated(function ($state, callable $set) {
                                //$producto = Producto::find($state);
                                //$set('unidad', $producto->unidad ?? null);
                                if($state === null) {
                                    $set('cantidad', null);
                                }
                                
                            })
                            ->live()
                            ->native(false)
                            ->relationship(
                                name: 'producto',
                                titleAttribute: 'nombre',
                            )
                            //->label('Producto')
                            ->required(),
                        TextInput::make('cantidad')
                            ->numeric()
                            ->required(),
                        Placeholder::make('unidad')
                            ->content(function (Get $get, Set $set): string {
                                $unidad = Producto::find($get('producto_id'))?->unidad;
                                
                                return $unidad ?? '';
                            })
                        
                    ])
                    ->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('compra.titulo')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('Observaciones')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pedidos_detalles')
                    ->label('Productos')
                    ->formatStateUsing(function ($record) {
                        $productos = $record->pedidos_detalles->map(function ($detalle) {
                            return $detalle->producto->nombre . ' (' . $detalle->cantidad . ' '  . $detalle->producto->unidad . ')'  ;
                        });

                        // Envolver cada producto en un párrafo <p>
                        return '<p>' . implode('</p><p>', $productos->toArray()) . '</p>';
                    })->html(),
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
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->groups([
                'compra.titulo',
                'user.name',
            ])
            ->defaultGroup('compra.titulo');
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
            'index' => Pages\ListPedidos::route('/'),
            'create' => Pages\CreatePedido::route('/create'),
            'edit' => Pages\EditPedido::route('/{record}/edit'),
        ];
    }
}
