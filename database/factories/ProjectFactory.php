<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Project>
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
//            'priority' => fake()
//                ->randomElement(['low', 'medium', 'high']),
            'image_path' => fake()->imageUrl(),
//            'assigned_user_id' => fake()->randomElement([1, 2]),
            'created_by' => User::factory()->create()->id,
            'updated_by' => User::factory()->create()->id,
            'created_at' => time(),
            'updated_at' => time(),

        ];
    }
}
