<?php

namespace App\Filament\Resources\ComprasResource\Pages;

use App\Filament\Resources\ComprasResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCompras extends ListRecords
{
    protected static string $resource = ComprasResource::class;

    protected function getHeaderActions(): array
    {
        $actions = [];

        // Chequear si el usuario autenticado es administrador
        if (auth()->user()->admin) {
            $actions[] = Actions\CreateAction::make('create');
                /*->label('Create New Record')
                ->url(route('your.resource.create'));*/
        }

        return $actions;
        /*return [
            Actions\CreateAction::make(),
        ];*/
    }
}
