<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function update(User $user, Post $post): bool
    {
        return $post->profile->is($user->profile);
    }
}
