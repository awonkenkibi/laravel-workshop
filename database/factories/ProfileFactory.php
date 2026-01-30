<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
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
        $handle = $this->faker->unique()->userName();

        return [
            'user_id' => User::factory(),
            'display_name' => $this->faker->name(),
            'handle' => $handle,
            'bio' => $this->faker->sentences(3, true),
            'avatar_url' => 'https://i.pravatar.cc/90?u='.$handle,
            'cover_url' => 'http://dummyimage.com/1400x640/555/ECA749?text='.$handle,
        ];
    }
}
