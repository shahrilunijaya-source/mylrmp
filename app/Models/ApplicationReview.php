<?php

namespace App\Models;

use App\Enums\ApplicationDecision;
use App\Enums\ApplicationStage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicationReview extends Model
{
    protected $fillable = [
        'application_id',
        'reviewer_id',
        'stage',
        'decision',
        'comments',
        'reviewed_at',
    ];

    protected function casts(): array
    {
        return [
            'stage'       => ApplicationStage::class,
            'decision'    => ApplicationDecision::class,
            'reviewed_at' => 'datetime',
        ];
    }

    // Relations

    public function application(): BelongsTo
    {
        return $this->belongsTo(RegistrationApplication::class, 'application_id');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}
