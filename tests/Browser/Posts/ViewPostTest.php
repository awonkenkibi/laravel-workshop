<?php

use App\Models\Post;
use App\Models\Profile;

it('shows a single post', function () {
    $profile = Profile::factory()->create();
    $post = Post::factory()->for($profile)->create();

    $this->actingAs($profile->user);

    visit(route('posts.index'))
        ->click('@visit-post-link')
        ->assertSee($post->content);
});
