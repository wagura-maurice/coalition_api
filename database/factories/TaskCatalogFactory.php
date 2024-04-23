<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TaskCatalog>
 */
class TaskCatalogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            '_uid' => generateUID(\App\Models\TaskCatalog::class, $this->faker->numberBetween(4, 9)),
            'category_id' => \App\Models\TaskCategory::inRandomOrder()->value('id'),
            'title' => $this->faker->sentence(),
            'slug' => $this->faker->unique()->slug(),
            'description' => $this->faker->paragraph(5),
            'due_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            '_priority' => $this->faker->numberBetween(0, 9),
            '_status' => $this->faker->numberBetween(0, 4)
        ];
    }
}
