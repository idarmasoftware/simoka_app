<?php

namespace Database\Factories;

use App\Models\Assessment;
use App\Models\Child;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Assessment>
 */
class AssessmentFactory extends Factory
{
    protected $model = Assessment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $answers = [];
        $score = 0;
        for ($i = 1; $i <= 23; $i++) {
            $val = fake()->numberBetween(1, 5);
            $answers[$i] = $val;
            $score += $val;
        }

        if ($score <= 50) {
            $classification = 'Typical Performance';
        } elseif ($score <= 75) {
            $classification = 'Probable Difference';
        } else {
            $classification = 'Definite Difference';
        }

        return [
            'child_id' => Child::factory(),
            'therapis_id' => User::factory(),
            'answers' => $answers,
            'score' => $score,
            'result_classification' => $classification,
        ];
    }
}
