<?php

use App\Models\Post;
use App\Models\Profile;

it('likes a post', function () {
    $profile = Profile::factory()->create();

    $otherProfile = Profile::factory()->create();
    $post = Post::factory()->for($otherProfile)->create();

    $this->actingAs($profile->user);

    $profile->follow($otherProfile);

    visit(route('posts.index'))
        ->click('@like-post-button')
        ->assertSeeIn('@like-post-count', 1);

    expect($post->likes)->toHaveCount(1);
});
