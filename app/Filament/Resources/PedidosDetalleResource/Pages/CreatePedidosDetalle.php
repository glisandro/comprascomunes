<?php

namespace App\Filament\Resources\PedidosDetalleResource\Pages;

use App\Filament\Resources\PedidosDetalleResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePedidosDetalle extends CreateRecord
{
    protected static string $resource = PedidosDetalleResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
