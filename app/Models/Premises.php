<?php

namespace App\Models;

use App\Enums\MalaysianState;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Premises extends Model
{
    use SoftDeletes, LogsActivity;

    protected $fillable = [
        'name',
        'license_no',
        'owner_company_id',
        'address_line1',
        'address_line2',
        'postcode',
        'district',
        'state',
        'pic_name',
        'pic_phone',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'state'     => MalaysianState::class,
            'is_active' => 'boolean',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll()->logOnlyDirty();
    }

    public function ownerCompany(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'owner_company_id');
    }

    public function inspections(): MorphMany
    {
        return $this->morphMany(Inspection::class, 'target');
    }
}
