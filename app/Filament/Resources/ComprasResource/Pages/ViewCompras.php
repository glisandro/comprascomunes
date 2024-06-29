<?php

namespace App\Filament\Resources\ComprasResource\Pages;

use Filament\Actions;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\ComprasResource;
use App\Filament\Resources\ComprasResource\RelationManagers\PedidosRelationManager;
use App\Filament\Resources\PedidosResource;

class ViewCompras extends ViewRecord
{
    protected static string $resource = ComprasResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\TextEntry::make('descripcion'),
                Infolists\Components\TextEntry::make('fecha_compra'),
                Infolists\Components\TextEntry::make('estado')
                    ->columnSpanFull(),
            ]);
    }

    /*public function getRelationManagers(): array
    {
        return [
            PedidosRelationManager::class,
        ];
    }*/
}
