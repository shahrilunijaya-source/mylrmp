<?php

namespace Database\Factories;

use App\Enums\ProductStatus;
use App\Models\FormulationType;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name'                  => implode(' ', $this->faker->words(3)) . ' ' . $this->faker->numberBetween(100, 999),
            'registrant_company_id' => 1, // placeholder — overridden in test
            'formulation_type_id'   => FormulationType::inRandomOrder()->value('id'),
            'status'                => ProductStatus::Pending,
        ];
    }
}
