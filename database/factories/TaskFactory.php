<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'image_path' => $this->faker->imageUrl(),
            'assigned_user_id' => 1,
            'status' => $this->faker->randomElement(['pending', 'in_progress', 'completed']),
            'project_id' => $this->faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9]),
            'priority' => $this->faker->randomElement(['low', 'medium', 'high']),
            'created_by' => User::factory()->create()->id,
            'updated_by' => User::factory()->create()->id,
        ];
    }
}
