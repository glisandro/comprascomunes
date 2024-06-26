<?php

namespace App\Filament\Resources\ProductosResource\Pages;

use App\Filament\Resources\ProductosResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProductos extends ListRecords
{
    protected static string $resource = ProductosResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
