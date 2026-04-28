<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InspectionChecklistResponse extends Model
{
    protected $fillable = [
        'inspection_id',
        'checklist_item_id',
        'answer',
        'note',
    ];

    public function inspection(): BelongsTo
    {
        return $this->belongsTo(Inspection::class);
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(InspectionChecklistItem::class, 'checklist_item_id');
    }
}
