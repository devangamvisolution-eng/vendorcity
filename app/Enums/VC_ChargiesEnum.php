<?php

namespace App\Enums;

enum VC_ChargiesEnum: string
{
    case COD = 'cod';
    case VAT_PERCENT = 'vat';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function percentage(): int
    {
        return match ($this) {
            self::COD => 10,
            self::VAT_PERCENT => 5,
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::COD => 'Cash On Delivery',
            self::VAT_PERCENT => 'VAT Charge',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($case) => [$case->value => $case->label()])
            ->toArray();
    }
}
