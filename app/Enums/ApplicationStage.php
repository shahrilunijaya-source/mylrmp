<?php

namespace App\Enums;

enum ApplicationStage: string
{
    case Draft = 'draft';
    case Submitted = 'submitted';
    case TechReview = 'tech_review';
    case LabelReview = 'label_review';
    case Decision = 'decision';
    case Approved = 'approved';
    case Rejected = 'rejected';
    case NeedsRevision = 'needs_revision';

    public function label(): string
    {
        return match($this) {
            self::Draft         => 'Draf',
            self::Submitted     => 'Dihantar',
            self::TechReview    => 'Penilaian Teknikal',
            self::LabelReview   => 'Penilaian Label',
            self::Decision      => 'Keputusan',
            self::Approved      => 'Diluluskan',
            self::Rejected      => 'Ditolak',
            self::NeedsRevision => 'Perlukan Semakan',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::Draft         => 'gray',
            self::Submitted     => 'info',
            self::TechReview    => 'warning',
            self::LabelReview   => 'warning',
            self::Decision      => 'primary',
            self::Approved      => 'success',
            self::Rejected      => 'danger',
            self::NeedsRevision => 'warning',
        };
    }
}
