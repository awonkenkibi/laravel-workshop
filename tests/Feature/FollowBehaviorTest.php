<?php

use App\Models\Follow;
use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('profile cannot follow itself', function () {
    $profile = Profile::factory()->create();

    expect(fn (): Follow => Follow::createFollow($profile, $profile))
        ->toThrow(InvalidArgumentException::class, 'A profile cannot follow itself.');
});

test('profile can follow another profile', function () {
    $profile1 = Profile::factory()->create();
    $profile2 = Profile::factory()->create();

    $follow = Follow::createFollow($profile1, $profile2);

    expect($profile1->followings->contains($profile2))->toBeTrue();
    expect($profile2->followers->contains($profile1))->toBeTrue();
    expect($follow->follower->id)->toBe($profile1->id);
    expect($follow->following->id)->toBe($profile2->id);
});

test('profile can unfollow profile', function () {
    $profile1 = Profile::factory()->create();
    $profile2 = Profile::factory()->create();

    $follow = Follow::createFollow($profile1, $profile2);
    $success = Follow::removeFollow($profile1, $profile2);

    expect($profile1->followings->contains($profile2))->toBeFalse();
    expect($profile2->followers->contains($profile1))->toBeFalse();
    expect($success)->toBeTrue();
    expect($follow->fresh())->toBeNull();
});
