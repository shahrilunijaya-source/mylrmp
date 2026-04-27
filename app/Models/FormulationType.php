<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FormulationType extends Model
{
    protected $fillable = [
        'code',
        'name_ms',
        'name_en',
    ];

    // Relations

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
