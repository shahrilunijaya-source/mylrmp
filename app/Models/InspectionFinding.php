<?php

namespace App\Models;

use App\Enums\FindingSeverity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InspectionFinding extends Model
{
    protected $fillable = [
        'inspection_id',
        'severity',
        'category',
        'linked_product_id',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'severity' => FindingSeverity::class,
        ];
    }

    public function inspection(): BelongsTo
    {
        return $this->belongsTo(Inspection::class);
    }

    public function linkedProduct(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'linked_product_id');
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(InspectionFindingAttachment::class, 'finding_id');
    }
}
