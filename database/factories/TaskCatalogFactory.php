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
            '_uid' => $this->faker->unique()->uuid(),
            'category_id' => \App\Models\TaskCategory::inRandomOrder()->value('id'),
            'priority_id' => \App\Models\TaskPriority::inRandomOrder()->value('id'),
            'title' => $this->faker->sentence(),
            'slug' => $this->faker->unique()->slug(),
            'description' => $this->faker->paragraph(5),
            'due_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            '_status' => $this->faker->numberBetween(0, 4)
        ];
    }
}
