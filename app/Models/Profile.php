<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\ProfileFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Profile extends Model
{
    /** @use HasFactory<ProfileFactory> */
    use HasFactory;

    protected $fillable = [
        // 'name',
        'display_name',
        'handle',
        'bio',
        'avatar_url',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function topLevelPosts(): HasMany
    {
        return $this->hasMany(Post::class)->whereNull('parent_id');
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function follow(Profile $profile): void
    {
        Follow::createFollow($this, $profile);
    }

    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(
            Profile::class,
            'follows',
            'following_profile_id',
            'follower_profile_id',
        );
    }

    public function followings(): BelongsToMany
    {
        return $this->belongsToMany(
            Profile::class,
            'follows',
            'follower_profile_id',
            'following_profile_id',
        );
    }

    public function isFollowing(Profile $profile): bool
    {
        return $this->followings()->where('following_profile_id', $profile->id)->exists();
    }
}
