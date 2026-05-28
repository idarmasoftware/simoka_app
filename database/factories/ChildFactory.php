<?php

namespace Database\Factories;

use App\Models\Child;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Child>
 */
class ChildFactory extends Factory
{
    protected $model = Child::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'parent_id' => User::factory(),
            'therapis_id' => User::factory(),
            'nama_lengkap' => fake()->name(),
            'tanggal_lahir' => fake()->date('Y-m-d', 'now'),
            'jenis_kelamin' => fake()->randomElement(['L', 'P']),
            'catatan_medis' => fake()->paragraph(),
            'is_active' => true,
        ];
    }
}
