<?php

namespace App\Models;

use App\Enums\ProductStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Product extends Model
{
    use LogsActivity;

    protected $fillable = [
        'name',
        'registrant_company_id',
        'formulation_type_id',
        'registration_no',
        'status',
        'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'status'     => ProductStatus::class,
            'expires_at' => 'date',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty();
    }

    // Relations

    public function registrant(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'registrant_company_id');
    }

    public function formulationType(): BelongsTo
    {
        return $this->belongsTo(FormulationType::class);
    }

    public function activeIngredients(): BelongsToMany
    {
        return $this->belongsToMany(ActiveIngredient::class, 'product_active_ingredient')
            ->withPivot('concentration_percent');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(RegistrationApplication::class);
    }

    public function certificate(): HasOneThrough
    {
        return $this->hasOneThrough(
            Certificate::class,
            RegistrationApplication::class,
            'product_id',       // FK on registration_applications
            'application_id',   // FK on certificates
            'id',               // local key on products
            'id'                // local key on registration_applications
        );
    }
}
