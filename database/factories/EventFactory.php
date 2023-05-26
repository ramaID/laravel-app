<?php

namespace Database\Factories;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => random_int(1, 1_000),
            'type' => Arr::random(['ALERT', 'WARNING', 'INFO']),
            'description' => $this->faker->realText(),
            'value' => random_int(1, 10),
            'date' => $this->faker->dateTimeThisYear(),
        ];
    }
}
