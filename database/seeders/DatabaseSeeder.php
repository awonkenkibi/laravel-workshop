<?php

namespace Database\Seeders;

use App\Models\Follow;
use App\Models\Like;
use App\Models\Post;
use App\Models\Profile;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $profiles = Profile::factory()->count(20)->create();

        foreach ($profiles as $profile) {
            Post::factory()->count(5)->create(['profile_id' => $profile->id]);
        }

        $posts = Post::all();

        foreach ($profiles as $profile) {
            $toFollow = $profiles->except($profile->id)->random(rand(3, 7));

            foreach ($toFollow as $target) {
                Follow::createFollow($profile, $target);
            }
        }

        foreach ($profiles as $profile) {
            $toLike = $posts->where('profile_id', '!=', $profile->id)->random(rand(10, 20));

            foreach ($toLike as $post) {
                Like::createLike($profile, $post);
            }
        }

        foreach ($profiles as $profile) {
            $toRepost = $posts->where('profile_id', '!=', $profile->id)->random(rand(2, 5));

            foreach ($toRepost as $post) {
                Post::repost($profile, $post, rand(0, 1) ? null : 'Great Post!');
            }
        }

        for ($ii = 0; $ii < rand(20, 30); $ii++) {
            $parentPost = $posts->random();
            $replier = $profiles->where('id', '!=', $parentPost->profile_id)->random();

            Post::factory()->reply($parentPost)->create(['profile_id' => $replier->id]);
        }

    }
}
