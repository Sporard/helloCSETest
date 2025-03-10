<?php

namespace Database\Factories;

use App\Models\Profile;
use App\Models\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'lastName' => fake()->name(),
            'firstName' => fake()->name(),
            'image' => asset(Profile::BASLINE_IMAGE_PROFILE_PATH),
            'status' => fake()->randomElement(Status::cases())->value,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
