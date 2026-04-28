<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InspectionChecklistItem extends Model
{
    protected $fillable = [
        'code',
        'category',
        'prompt_en',
        'prompt_ms',
        'applies_to',
        'display_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active'     => 'boolean',
            'display_order' => 'integer',
        ];
    }

    public function responses(): HasMany
    {
        return $this->hasMany(InspectionChecklistResponse::class, 'checklist_item_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('display_order');
    }

    public function scopeForTarget($query, string $targetType)
    {
        $type = class_basename($targetType);

        return $query->whereIn('applies_to', [$type, 'Both']);
    }
}
