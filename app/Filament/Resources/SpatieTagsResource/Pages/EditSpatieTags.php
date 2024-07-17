<?php

namespace App\Filament\Resources\SpatieTagsResource\Pages;

use App\Filament\Resources\SpatieTagsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSpatieTags extends EditRecord
{
    protected static string $resource = SpatieTagsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
