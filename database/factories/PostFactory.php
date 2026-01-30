<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'profile_id' => Profile::factory(),
            'parent_id' => null,
            'repost_of_id' => null,
            'content' => $this->faker->realText(200),
        ];
    }

    public function repost(Post $originalPost)
    {
        return $this->state([
            'repost_of_id' => $originalPost->id,
            'content' => null,
        ]);
    }

    public function quotePost(Post $originalPost)
    {
        return $this->state([
            'repost_of_id' => $originalPost->id,
            'content' => $this->faker->realText(200),
        ]);
    }

    public function reply(Post $parentPost)
    {
        return $this->state([
            'parent_id' => $parentPost->id,
            'content' => $this->faker->realText(200),
        ]);
    }
}
