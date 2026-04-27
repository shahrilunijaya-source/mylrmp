<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductCategory extends Model
{
    protected $fillable = [
        'name_ms',
        'name_en',
        'slug',
        'sort_order',
    ];

    // Relations

    public function applications(): HasMany
    {
        return $this->hasMany(RegistrationApplication::class, 'category_id');
    }
}
