<?php

namespace App\Enums;

enum ApplicationDecision: string
{
    case Pending       = 'pending';
    case Approved      = 'approved';
    case Rejected      = 'rejected';
    case NeedsRevision = 'needs_revision';

    public function label(): string
    {
        return match($this) {
            self::Pending       => 'Menunggu',
            self::Approved      => 'Diluluskan',
            self::Rejected      => 'Ditolak',
            self::NeedsRevision => 'Perlukan Semakan',
        };
    }
}
