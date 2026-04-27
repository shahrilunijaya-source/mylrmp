<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ActiveIngredient extends Model
{
    protected $fillable = [
        'name',
        'cas_no',
        'is_gazetted',
    ];

    protected function casts(): array
    {
        return [
            'is_gazetted' => 'boolean',
        ];
    }

    // Relations

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_active_ingredient')
            ->withPivot('concentration_percent');
    }
}
