## Laravel Workshop - Pixl

This is the source code for the demo project, Pixl, from Laracasts. 

[The Laravel Workshop](https://laracasts.com/series/the-laravel-workshop)

At the conclusion of Section 3, we pass it over to YOU. 

## Section 4

At this point, we have a working SPA that can be pushed to production. But, of course, there's so much more to do. Here are some ideas, if you'd like to continue your learning:

1. Implement the Bookmarking feature. When the user clicks the bookmark icon, the `user_id` and `post_id` fields should be inserted into a new `bookmarks` table that you create.
2. Implement the UI and forms for registration, login, and profile editing. Then update the dev-specific endpoints within your `routes/web.php` file accordingly.
3. Use [Laravel Socialite](https://laravel.com/docs/12.x/socialite) to add "Sign In With Google" and "Sign In With GitHub" functionality.
4. Both `PostController` and `ProfileController` include non-resourceful actions. While this is okay, consider extracting new controllers. Perhaps the `like` and `unlike` within `PostController` could be extracted to a `LikePostController` controller. This would allow you to return to `store` and `destroy` action/method names.
5. Add a "Highlights" feature. Any user may mark their own post as "highlighted." This will make the post show up within the "Highlights" tab on their profile page.
6. Add support for attaching an image to a post. Research Laravel's `Storage` component [to learn more](https://laravel.com/docs/12.x/filesystem#specifying-a-disk).
