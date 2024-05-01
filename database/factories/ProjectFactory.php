<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use function PHPUnit\Framework\assertEqualsIgnoringCase;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(),
            'description' => fake()->realText(),
            'due_date' => fake()->dateTimeBetween('now', '+1 year'),
            'status' => fake()
                ->randomElement(['pending', 'in_progress', 'completed']),
            'priority' => fake()
                ->randomElement(['low', 'medium', 'high']),
            'image_path' => fake()->imageUrl(),
            'assigned_user_id' => fake()->randomElement([1, 2]),
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => time(),
            'updated_at' => time(),

        ];
    }
}
