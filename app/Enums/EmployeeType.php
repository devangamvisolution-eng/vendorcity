<?php

namespace App\Enums;

enum EmployeeType: string
{
    case DRIVER = 'driver';
    case CREW = 'crew';
    case OFFICE_STAFF = 'office-staff';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match ($this) {
            self::DRIVER => 'Driver',
            self::CREW => 'Crew',
            self::OFFICE_STAFF => 'Office Staff',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($case) => [$case->value => $case->label()])
            ->toArray();
    }
}
