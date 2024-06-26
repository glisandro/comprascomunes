<?php

namespace App\Filament\Resources\PedidosDetalleResource\Pages;

use App\Filament\Resources\PedidosDetalleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPedidosDetalle extends EditRecord
{
    protected static string $resource = PedidosDetalleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
