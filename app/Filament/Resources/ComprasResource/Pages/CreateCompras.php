<?php

namespace App\Filament\Resources\ComprasResource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\ComprasResource;

class CreateCompras extends CreateRecord
{
    protected static string $resource = ComprasResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id(); // Establece el user_id al ID del usuario autenticado
        return $data;
    }
}
