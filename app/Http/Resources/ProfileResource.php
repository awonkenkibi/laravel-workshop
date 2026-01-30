<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'cover_url' => $this->cover_url,
            'avatar_url' => $this->avatar_url,
            'display_name' => $this->display_name,
            'handle' => $this->handle,
            'bio' => $this->bio,
            'followers_count' => $this->whenCounted('followers'),
            'followings_count' => $this->whenCounted('followings'),
            'posts_count' => $this->whenCounted('posts'),
            'replies_count' => $this->whenCounted('replies'),
            'reposts_count' => $this->whenCounted('reposts'),
            'likes_count' => $this->whenCounted('likes'),
            'has_followed' => $this->has_followed ?? false,
        ];
    }
}
