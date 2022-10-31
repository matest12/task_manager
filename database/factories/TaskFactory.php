<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
      return [
          "subject" => $this->faker->name(),
          "description" => $this->faker->paragraph,
          "start_at" => $this->faker->date,
          "finish_at" => $this->faker->date,
          "user_id" => $this->faker->randomElement([
              1,
              3,
              4
          ]),

      ];
    }
}
