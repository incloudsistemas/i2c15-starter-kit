<?php

namespace App\Enums;

use App\Traits\EnumHelper;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum DefaultStatusEnum: string implements HasLabel, HasColor
{
    use EnumHelper;

    case ACTIVE   = '1';
    case INACTIVE = '0';

    public function getLabel(): string
    {
        return match ($this) {
            self::ACTIVE   => 'Ativo',
            self::INACTIVE => 'Inativo',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::ACTIVE   => 'success',
            self::INACTIVE => 'danger',
        };
    }
}
