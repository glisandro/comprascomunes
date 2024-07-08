<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum EstadoCompra: string implements HasColor, HasIcon, HasLabel
{
    case Open = 'open';

    case Closed = 'closed';

    case Cancelled = 'cancelled';

    public function getLabel(): string
    {
        return match ($this) {
            self::Open => 'Abierta',
            self::Closed => 'Cerrada',
            self::Cancelled => 'Cancelada',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Open => 'success',
            self::Closed => 'danger',
            self::Cancelled => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Open => 'heroicon-m-sparkles',
            self::Closed => 'heroicon-m-no-symbol',
            self::Cancelled => 'heroicon-m-no-symbol',
        };
    }
}