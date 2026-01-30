<?php

declare(strict_types=1);

namespace App\Queries;

use App\Models\Post;
use App\Models\Profile;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class ProfilePageQuery
{
    public function __construct(
        private Profile $subject,
        private ?Profile $viewer) {}

    public static function for(Profile $subject, ?Profile $viewer): self
    {
        return new self($subject, $viewer);
    }

    public function paginate(int $perPage = 20): LengthAwarePaginator
    {
        return $this->baseQuery()->paginate($perPage)->through(fn (Post $post): Post => $this->normalize($post));
    }

    public function get(): Collection
    {
        return $this->baseQuery()->get()->map(fn (Post $post): Post => $this->normalize($post));
    }

    private function baseQuery(): Builder
    {
        $viewerId = $this->viewer?->id ?? 0;

        return Post::where('profile_id', $this->subject->id)
            ->whereNull('parent_id')
            ->with([
                'profile',
                'repostOf' => fn ($q) => $q
                    ->withCount(['likes', 'reposts', 'replies'])
                    ->with('profile'),
            ])
            ->withCount(['likes', 'reposts', 'replies'])
            ->withExists([
                'likes as has_liked' => fn ($q) => $q->where('profile_id', $viewerId),
                'reposts as has_reposted' => fn ($q) => $q->where('profile_id', $viewerId),
                'repostOf as like_original' => fn ($q) => $q->whereHas('likes', fn ($q) => $q->where('profile_id', $viewerId)),
                'repostOf as repost_original' => fn ($q) => $q->whereHas('reposts', fn ($q) => $q->where('profile_id', $viewerId)),
            ])
            ->latest();
    }

    private function normalize(Post $post): Post
    {
        if ($post->isRepost() && is_null($post->content)) {
            $post->repostOf->has_liked = (bool) $post->like_original;
            $post->repostOf->has_reposted = (bool) $post->repost_original;
        }

        return $post;
    }
}
