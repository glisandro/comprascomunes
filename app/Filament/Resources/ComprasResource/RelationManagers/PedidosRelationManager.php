<?php

namespace App\Filament\Resources\ComprasResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use App\Models\compra;
use Filament\Forms\Get;
use App\Models\Producto;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class PedidosRelationManager extends RelationManager
{
    protected static string $relationship = 'pedidos';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                
                Repeater::make('pedidoDetalle')
                    ->addActionLabel('Agregar producto')
                    ->label('Productos')
                    ->relationship()
                    ->schema([
                        Select::make('producto_id')
                            ->afterStateUpdated(function ($state, callable $set) {
                                if($state === null) {
                                    $set('cantidad', null);
                                }
                            })
                            ->live()
                            ->searchable()
                            ->preload()
                            ->placeholder('Seleccione un producto')
                            ->native(false)
                            ->relationship(
                                name: 'producto',
                                titleAttribute: 'nombre',
                            )
                            //->label('Producto')
                            ->createOptionForm([
                                Forms\Components\TextInput::make('nombre')
                                    ->required(),
                                Forms\Components\TextInput::make('descripcion'),
                                Forms\Components\TextInput::make('unidad')
                                    ->required(),
                            ])
                            ->required(),
                        TextInput::make('cantidad')
                            ->numeric()
                            ->required(),
                        Placeholder::make('unidad')
                            ->content(function (Get $get): string {
                                $unidad = Producto::find($get('producto_id'))?->unidad;
                                
                                return $unidad ?? '';
                            })
                        
                    ])
                    ->columns(3),
                
                Forms\Components\TextInput::make('Observaciones')
                    ->placeholder('Acá podés agregar un compentario sobre tu pedido'),
            ])
            ->columns(1);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Aquí puedes modificar los datos antes de que se cree el registro
        $data['user_id'] = auth()->id();  // Agregar el user_id del usuario autenticado

        return $data;
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('user.name'),
                Tables\Columns\TextColumn::make('created_at'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                //Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Nuevo Pedido')
                  ->createAnother(false)
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    BulkAction::make('viewDetails')
                    ->label('Ver Listado de compras')
                    ->action(function ($records) {
                        // Extraer IDs de los registros
                        $pedidoIds = $records->pluck('id')->toArray();
                        $pedidoIdsQueryString = implode('&', array_map(fn ($id) => "tableFilters[pedido][values][]={$id}", $pedidoIds));
                        $url = url("/pedidos-detalles?{$pedidoIdsQueryString}");
                        return redirect($url);
                    })

                  
                ]),
            ]);
    }

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }

    public function isReadOnly(): bool
    {
        return false;
    }
}
