<?php

namespace App\Filament\Resources\PedidosResource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use App\Filament\Resources\PedidosResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePedidos extends CreateRecord
{
    protected static string $resource = PedidosResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id(); // Establece el user_id al ID del usuario autenticado
        return $data;
    }

    protected function afterSave(): void
    {
        $this->redirect($this->getResource()::getUrl('index'));
    }

    protected function beforeCreate(): void
{
    if (! $this->record->team->subscribed()) {
        Notification::make()
            ->warning()
            ->title('You don\'t have an active subscription!')
            ->body('Choose a plan to continue.')
            ->persistent()
            ->actions([
                Action::make('subscribe')
                    ->button()
                    ->url(route('subscribe'), shouldOpenInNewTab: true),
            ])
            ->send();
    
        $this->halt();
    }
}
}
