<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\TaskStep;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TaskStep>
 */
class TaskStepFactory extends Factory
{
    protected $model = TaskStep::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'task_id' => Task::factory(),
            'step_number' => 1,
            'instruction' => fake()->sentence(),
            'video_path' => null,
            'notes' => null,
            'feedback' => null,
            'status' => 'pending',
        ];
    }
}
