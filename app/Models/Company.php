<?php

namespace App\Models;

use App\Enums\CompanyStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Company extends Model
{
    use LogsActivity;

    protected $fillable = [
        'name',
        'ssm_no',
        'address',
        'phone',
        'email',
        'contact_person',
        'status',
        'registered_at',
    ];

    protected function casts(): array
    {
        return [
            'status'        => CompanyStatus::class,
            'registered_at' => 'datetime',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty();
    }

    // Relations

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function registeredProducts(): HasMany
    {
        return $this->hasMany(Product::class, 'registrant_company_id');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(RegistrationApplication::class, 'applicant_company_id');
    }

    public function inspections(): MorphMany
    {
        return $this->morphMany(Inspection::class, 'target');
    }
}
