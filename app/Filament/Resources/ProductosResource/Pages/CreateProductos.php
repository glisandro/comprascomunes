<?php

namespace App\Filament\Resources\ProductosResource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\ProductosResource;

class CreateProductos extends CreateRecord
{
    protected static string $resource = ProductosResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id(); // Establece el user_id al ID del usuario autenticado
        return $data;
    }
}
