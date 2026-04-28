<?php

namespace App\Models;

use App\Enums\InspectionStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Inspection extends Model
{
    use LogsActivity;

    protected $fillable = [
        'inspection_no',
        'target_type',
        'target_id',
        'inspector_id',
        'scheduled_for',
        'conducted_at',
        'status',
        'summary',
        'report_pdf_path',
        'notice_pdf_path',
        'notice_deadline',
    ];

    protected function casts(): array
    {
        return [
            'status'         => InspectionStatus::class,
            'scheduled_for'  => 'date',
            'conducted_at'   => 'datetime',
            'notice_deadline' => 'date',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll()->logOnlyDirty();
    }

    public function target(): MorphTo
    {
        return $this->morphTo();
    }

    public function inspector(): BelongsTo
    {
        return $this->belongsTo(User::class, 'inspector_id');
    }

    public function checklistResponses(): HasMany
    {
        return $this->hasMany(InspectionChecklistResponse::class);
    }

    public function findings(): HasMany
    {
        return $this->hasMany(InspectionFinding::class);
    }

    public function targetLabel(): string
    {
        $target = $this->target;
        if (! $target) {
            return '—';
        }

        return $target instanceof Premises
            ? "Premis: {$target->name}"
            : "Syarikat: {$target->name}";
    }
}
