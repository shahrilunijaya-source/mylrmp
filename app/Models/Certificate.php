<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certificate extends Model
{
    protected $fillable = [
        'application_id',
        'registration_no',
        'issued_at',
        'expires_at',
        'pdf_path',
        'qr_code',
    ];

    protected function casts(): array
    {
        return [
            'issued_at'  => 'datetime',
            'expires_at' => 'date',
        ];
    }

    // Relations

    public function application(): BelongsTo
    {
        return $this->belongsTo(RegistrationApplication::class, 'application_id');
    }
}
