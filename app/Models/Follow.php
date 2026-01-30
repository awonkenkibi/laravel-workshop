<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use InvalidArgumentException;

class Follow extends Model
{
    /** @use HasFactory<\Database\Factories\FollowFactory> */
    use HasFactory;

    protected $fillable = [
        'follower_profile_id',
        'following_profile_id',
    ];

    public function follower(): BelongsTo
    {
        return $this->belongsTo(Profile::class, 'follower_profile_id');
    }

    public function following(): BelongsTo
    {
        return $this->belongsTo(Profile::class, 'following_profile_id');
    }

    public static function createFollow(Profile $follower, Profile $following): self
    {
        if ($follower->id === $following->id) {
            throw new InvalidArgumentException('A profile cannot follow itself.');
        }

        return static::firstOrCreate([
            'follower_profile_id' => $follower->id,
            'following_profile_id' => $following->id,
        ]);
    }

    public static function removeFollow(Profile $follower, Profile $following): bool
    {
        if ($follower->id === $following->id) {
            throw new InvalidArgumentException('A profile cannot unfollow itself.');
        }

        return static::where('follower_profile_id', $follower->id)
            ->where('following_profile_id', $following->id)
            ->delete() > 0;
    }
}
