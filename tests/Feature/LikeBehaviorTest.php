<?php

use App\Models\Like;
use App\Models\Post;
use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('profile can like post', function () {
    $profile = Profile::factory()->create();
    $post = Post::factory()->create();

    $like = Like::createLike($profile, $post);

    expect($profile->likes)->toHaveCount(1)
        ->and($profile->likes->contains($like))->toBeTrue()
        ->and($post->likes)->toHaveCount(1)
        ->and($post->likes->contains($like))->toBeTrue()
        ->and($like->post->is($post))->toBeTrue()
        ->and($like->profile->is($profile))->toBeTrue();
});

test('cannot create duplicate likes', function () {
    $profile = Profile::factory()->create();
    $post = Post::factory()->create();

    $l1 = Like::createLike($profile, $post);
    $l2 = Like::createLike($profile, $post);

    expect($l1->id)->toBe($l2->id);
});

test('can remove a like', function () {
    $profile = Profile::factory()->create();
    $post = Post::factory()->create();

    $like = Like::createLike($profile, $post);

    $success = Like::removeLike($profile, $post);

    expect($profile->likes)->toHaveCount(0)
        ->and($profile->likes->contains($like))->toBeFalse()
        ->and($post->likes)->toHaveCount(0)
        ->and($post->likes->contains($like))->toBeFalse()
        ->and($success)->toBeTrue();
});
