<?php

namespace App\Enums;

enum ProductStatus: string
{
    case Pending   = 'pending';
    case Active    = 'active';
    case Expired   = 'expired';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match($this) {
            self::Pending   => 'Menunggu',
            self::Active    => 'Aktif',
            self::Expired   => 'Tamat Tempoh',
            self::Cancelled => 'Dibatalkan',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::Pending   => 'gray',
            self::Active    => 'success',
            self::Expired   => 'warning',
            self::Cancelled => 'danger',
        };
    }
}
