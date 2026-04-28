<?php

namespace App\Enums;

enum FindingSeverity: string
{
    case Minor = 'minor';
    case Major = 'major';

    public function label(): string
    {
        return match($this) {
            self::Minor => 'Kecil',
            self::Major => 'Major',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::Minor => 'warning',
            self::Major => 'danger',
        };
    }
}
