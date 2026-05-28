<?php

namespace Database\Factories;

use App\Models\Assessment;
use App\Models\Child;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'assessment_id' => Assessment::factory(),
            'child_id' => Child::factory(),
            'therapis_id' => User::factory(),
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'status' => 'pending',
        ];
    }
}
