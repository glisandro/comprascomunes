<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum Estado: string implements HasColor, HasIcon, HasLabel
{
    case New = 'new';

    case Open = 'open';

    case Closed = 'closed';

    case Cancelled = 'cancelled';

    public function getLabel(): string
    {
        return match ($this) {
            self::New => 'Nueva',
            self::Open => 'Abierta',
            self::Closed => 'Cerrada',
            self::Cancelled => 'Cancelada',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::New => 'info',
            self::Open => 'success',
            self::Closed => 'info',
            self::Cancelled => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::New => 'heroicon-m-sparkles',
            self::Open => 'heroicon-m-arrow-path',
            self::Closed => 'heroicon-m-check-badge',
            self::Cancelled => 'heroicon-m-x-circle',
        };
    }
}