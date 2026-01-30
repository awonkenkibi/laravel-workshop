<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({ profile: Object });
</script>

<template>
    <div>
        <header>
            <img :src="profile.cover_url" alt="" />
            <div class="-mt-10 flex flex-wrap items-end justify-between gap-4 md:-mt-16">
                <div class="flex items-end gap-4">
                    <img :src="profile.avatar_url" :alt="`Avatar for ${profile.display_name}`"
                        class="size-20 object-cover md:size-32" />
                    <div class="flex flex-col text-sm md:gap-1">
                        <p class="text-lg md:text-xl">{{ profile.display_name }}</p>
                        <p class="text-pixl-light/60 text-sm">@{{ profile.handle }}</p>
                    </div>
                </div>

                <Link v-if="$page.props.auth.user && profile.id !== $page.props.auth.user?.profile.id" method="POST"
                    :href="route(profile.has_followed ? 'profiles.unfollow' : 'profiles.follow', profile)"
                    class="bg-pixl-dark/50 hover:bg-pixl-dark/60 active:bg-pixl-dark/75 border-pixl/50 hover:border-pixl/60 active:border-pixl/75 text-pixl border px-2 py-1 text-sm"
                    data-test="follow-button">
                {{ profile.has_followed ? 'Unfollow' : 'Follow' }}
                </Link>
            </div>
            <div class="[&_a]:text-pixl mt-8 [&_a]:hover:underline">
                <p>{{ profile.bio }}</p>
            </div>
            <dl class="mt-6 flex gap-6">
                <div class="flex gap-1.5">
                    <dd>{{ profile.followings_count }}</dd>
                    <dt class="text-pixl-light/60">Following</dt>
                </div>
                <div class="flex gap-1.5">
                    <dd>{{ profile.followers_count }}</dd>
                    <dt class="text-pixl-light/60">Followers</dt>
                </div>
            </dl>
        </header>

        <!-- Navigation/tabs -->
        <div class="mt-6 h-full">
            <nav class="overflow-x-auto [scrollbar-width:none]">
                <ul class="flex min-w-max justify-end gap-8 text-sm">
                    <li>
                        <Link :href="route('profiles.show', profile)"
                            :class="route().current('profiles.show') ? 'text-pixl' : 'text-pixl-light/60'">Posts</Link>
                    </li>
                    <li>
                        <Link class="hover:text-pixl-light/80"
                            :class="route().current('profiles.replies') ? 'text-pixl' : 'text-pixl-light/60'"
                            :href="route('profiles.replies', profile)">Replies</Link>
                    </li>
                    <li>
                        <a class="text-pixl-light/60 hover:text-pixl-light/80" href="#">Highlights</a>
                    </li>
                    <li>
                        <a class="text-pixl-light/60 hover:text-pixl-light/80" href="#">Inspiration Streams</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</template>