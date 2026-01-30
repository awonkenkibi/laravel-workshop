<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Models\Like;
use App\Models\Post;
use App\Models\Profile;
use App\Queries\PostThreadQuery;
use App\Queries\TimelineQuery;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PostController extends Controller
{
    // Show feed
    public function index()
    {
        $profile = Auth::user()->profile;

        // Get timeline posts, allow empty collection
        $posts = TimelineQuery::forViewer($profile)->get() ?? collect();

        return Inertia::render('Posts/Index', [
            'profile' => $profile?->toResource(),
            'posts' => $posts->toResourceCollection(),
        ]);
    }

    // Show a single post
    public function show(Profile $profile, Post $post)
    {
        $postThread = PostThreadQuery::for($post, Auth::user()?->profile)->load();

        return Inertia::render('Posts/Show', [
            'post' => $postThread?->toResource(),
        ]);
    }

    // Create a new post
    public function store(CreatePostRequest $request)
    {
        $profile = Auth::user()->profile;

        Post::publish($profile, $request->input('content'));

        return to_route('posts.index')->with('success', 'Your post is now live!');
    }

    // Reply to a post
    public function reply(Profile $profile, Post $post, CreatePostRequest $request): RedirectResponse
    {
        $currentProfile = Auth::user()->profile;

        Post::reply($currentProfile, $post, $request->input('content'));

        return back();
    }

    // Repost a post (optional content)
    public function repost(Profile $profile, Post $post, ?CreatePostRequest $request = null): RedirectResponse
    {
        $currentProfile = Auth::user()->profile;

        $content = $request?->input('content');

        Post::repost($currentProfile, $post, $content);

        return to_route('posts.index');
    }

    // Like a post
    public function like(Profile $profile, Post $post): RedirectResponse
    {
        $currentProfile = Auth::user()->profile;

        Like::createLike($currentProfile, $post);

        return back();
    }

    // Unlike a post
    public function unlike(Profile $profile, Post $post): RedirectResponse
    {
        $currentProfile = Auth::user()->profile;

        Like::removeLike($currentProfile, $post);

        return back();
    }

    // Delete a post
    public function destroy(Profile $profile, Post $post): RedirectResponse
    {
        $currentProfile = Auth::user()->profile;

        if ($currentProfile->can('update', $post)) {
            $post->delete();
        }

        // Delete reposts by current user
        $post->reposts()
            ->where('profile_id', $currentProfile->id)
            ->first()?->delete();

        return back();
    }
}
