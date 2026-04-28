<?php

namespace App\Enums;

enum InspectionStatus: string
{
    case Scheduled  = 'scheduled';
    case InProgress = 'in_progress';
    case Compliant  = 'compliant';
    case MinorNC    = 'minor_nc';
    case MajorNC    = 'major_nc';
    case Cancelled  = 'cancelled';

    public function label(): string
    {
        return match($this) {
            self::Scheduled  => 'Dijadualkan',
            self::InProgress => 'Sedang Dijalankan',
            self::Compliant  => 'Akur',
            self::MinorNC    => 'Ketidakpatuhan Kecil',
            self::MajorNC    => 'Ketidakpatuhan Major',
            self::Cancelled  => 'Dibatalkan',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::Scheduled  => 'info',
            self::InProgress => 'warning',
            self::Compliant  => 'success',
            self::MinorNC    => 'warning',
            self::MajorNC    => 'danger',
            self::Cancelled  => 'gray',
        };
    }

    public function isTerminal(): bool
    {
        return in_array($this, [self::Compliant, self::MinorNC, self::MajorNC, self::Cancelled]);
    }

    public function cssClass(): string
    {
        return match($this) {
            self::Scheduled  => 'st-sub',
            self::InProgress => 'st-tec',
            self::Compliant  => 'st-ok',
            self::MinorNC    => 'st-rev',
            self::MajorNC    => 'st-rej',
            self::Cancelled  => 'st-drf',
        };
    }

    public function requiresNotice(): bool
    {
        return in_array($this, [self::MinorNC, self::MajorNC]);
    }
}
