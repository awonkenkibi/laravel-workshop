<?php

use App\Models\Post;
use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('allows a profile to publish a post', function () {
    $profile = Profile::factory()->create();

    $post = Post::publish($profile, 'Content of the post');

    expect($post->exists)->toBeTrue()
        ->and($post->profile->is($profile))->toBeTrue()
        ->and($post->parent_id)->toBeNull()
        ->and($post->repost_of_id)->toBeNull();
});

test('can reply to post', function () {
    $original = Post::factory()->create();

    $replier = Profile::factory()->create();
    $reply = Post::reply($replier, $original, 'reply content');

    expect($reply->parent->is($original))->toBeTrue()
        ->and($original->replies)->toHaveCount(1);
});

test('can have many replies', function () {
    $original = Post::factory()->create();
    $replies = Post::factory()->count(4)->reply($original)->create();

    expect($replies->first()->parent->is($original))->toBeTrue()
        ->and($original->replies)->toHaveCount(4)
        ->and($original->replies->contains($replies->first()))->toBeTrue();
});

test('create plain repost', function () {
    $original = Post::factory()->create();

    $repostProfile = Profile::factory()->create();
    $repost = Post::repost($repostProfile, $original);

    expect($repost->repostOf->is($original))->toBeTrue()
        ->and($original->reposts)->toHaveCount(1)
        ->and($repost->content)->toBeNull();
});

test('can have many reposts', function () {
    $original = Post::factory()->create();
    $reposts = Post::factory()->count(4)->repost($original)->create();

    expect($reposts->first()->repostOf->is($original))->toBeTrue()
        ->and($original->reposts)->toHaveCount(4)
        ->and($original->reposts->contains($reposts->first()))->toBeTrue();
});

test('create quote repost', function () {
    $content = 'quote content';
    $original = Post::factory()->create();

    $repostProfile = Profile::factory()->create();
    $repost = Post::repost($repostProfile, $original, $content);

    expect($repost->repostOf->is($original))->toBeTrue()
        ->and($original->reposts)->toHaveCount(1)
        ->and($repost->content)->toBe($content);
});

test('prevent duplicate reposts', function () {
    $original = Post::factory()->create();
    $profile = Profile::factory()->create();

    $post = Post::repost($profile, $original);
    $r2 = Post::repost($profile, $original);

    expect($post->id)->toBe($r2->id);
});

test('remove a repost', function () {
    $original = Post::factory()->create();
    $profile = Post::factory()->repost($original)->create()->profile;

    $success = Post::removeRepost($profile, $original);

    expect($original->reposts)->toHaveCount(0)
        ->and($success)->toBeTrue();
});
