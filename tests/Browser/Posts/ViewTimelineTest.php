<?php

use App\Models\Post;
use App\Models\Profile;

test('authenticated users can view their timeline', function () {
    $profile = Profile::factory()->create();
    Post::factory()->for($profile)->create(); // 1 post

    $otherProfile = Profile::factory()->create();
    Post::factory(2)->for($otherProfile)->create(); // 2 posts

    $this->actingAs($profile->user);

    $profile->follow($otherProfile);
    expect($profile->followings)->toHaveCount(1);

    visit(route('posts.index'))
        ->assertCount('@post-feed-item', 3);
});
