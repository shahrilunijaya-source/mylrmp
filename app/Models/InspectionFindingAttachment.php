<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class InspectionFindingAttachment extends Model
{
    protected $fillable = [
        'finding_id',
        'path',
        'mime',
        'size_bytes',
    ];

    protected function casts(): array
    {
        return [
            'size_bytes' => 'integer',
        ];
    }

    public function finding(): BelongsTo
    {
        return $this->belongsTo(InspectionFinding::class, 'finding_id');
    }

    public function url(): string
    {
        return Storage::disk('local')->url($this->path);
    }
}
