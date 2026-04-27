<?php

namespace App\Models;

use App\Enums\ApplicationStage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class RegistrationApplication extends Model
{
    use LogsActivity;

    protected $fillable = [
        'application_no',
        'category_id',
        'subcategory_id',
        'applicant_user_id',
        'applicant_company_id',
        'product_id',
        'current_stage',
        'submitted_at',
        'decided_at',
    ];

    protected function casts(): array
    {
        return [
            'current_stage' => ApplicationStage::class,
            'submitted_at'  => 'datetime',
            'decided_at'    => 'datetime',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty();
    }

    // Relations

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(ProductSubcategory::class, 'subcategory_id');
    }

    public function applicant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'applicant_user_id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'applicant_company_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(ApplicationDocument::class, 'application_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(ApplicationReview::class, 'application_id');
    }

    public function certificate(): HasOne
    {
        return $this->hasOne(Certificate::class, 'application_id');
    }
}
