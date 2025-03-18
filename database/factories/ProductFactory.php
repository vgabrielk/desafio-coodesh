<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->unique()->numberBetween(1000, 9999),
            'status' => 'draft',
            'imported_t' => $this->faker->dateTimeBetween('-1 years', 'now'),
            'url' => $this->faker->url(),
            'creator' => $this->faker->name(),
            'created_t' => $this->faker->dateTimeBetween('-2 years', '-1 years'),
            'last_modified_t' => $this->faker->dateTimeBetween('-1 years', 'now')->format('Y-m-d H:i:s'),
            'product_name' => $this->faker->word(),
            'quantity' => $this->faker->randomDigit() . ' pcs',
            'brands' => $this->faker->company(),
            'categories' => $this->faker->words(3, true),
            'labels' => $this->faker->words(2, true),
            'cities' => $this->faker->city(),
            'purchase_places' => $this->faker->city(),
            'stores' => $this->faker->company(),
            'ingredients_text' => $this->faker->sentence(10),
            'traces' => $this->faker->word(),
            'serving_size' => $this->faker->randomElement(['100g', '250ml', '1 piece']),
            'serving_quantity' => $this->faker->numberBetween(1, 10),
            'nutriscore_score' => $this->faker->numberBetween(-15, 40),
            'nutriscore_grade' => $this->faker->randomElement(['a', 'b', 'c', 'd', 'e']),
            'main_category' => $this->faker->word(),
            'image_url' => $this->faker->imageUrl(),
        ];
    }
}
