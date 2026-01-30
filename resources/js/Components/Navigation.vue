<script setup lang="ts">
import {Link, usePage} from '@inertiajs/vue3';
import Logo from './Logo.vue';
import {computed} from "vue";

let currentProfile = computed(() => {
    return usePage().props.auth.user.profile;
});
</script>

<template>
    <!-- Navigation -->
    <header class="my-4 hidden w-48 shrink-0 flex-col justify-between gap-8 pl-4 sm:flex xl:ml-32">
        <div class="overflow-y-auto">
            <!-- Logo -->
            <a href="/">
                <Logo />
            </a>

            <!-- Navigation -->
            <nav class="mt-10">
                <ul class="flex flex-col gap-3.5">
                    <li>
                        <a :href="route('posts.index')" class="hover:underline" :class="{ 'text-pixl': $page.component === 'Posts/Index' }">Home</a>
                    </li>
                    <li>
                        <a :href="route('profiles.show', currentProfile)" class="hover:underline" :class="{ 'text-pixl': $page.component === 'Profiles/Show' }">Profile</a>
                    </li>

                    <li><a class="hover:underline" href="#">Explore</a></li>
                    <!-- Active item -->
                    <li class="-ml-4 flex items-center gap-2">
                        <div class="bg-pixl size-2 shrink-0"></div>
                        <a class="hover:underline" href="#">Notifications</a>
                    </li>

                    <li><a class="hover:underline" href="#">Lists</a></li>
                    <li><a class="hover:underline" href="#">Bookmarks</a></li>
                    <li><a class="hover:underline" href="#">Jobs</a></li>
                    <li><a class="hover:underline" href="#">Communities</a></li>
                    <li><a class="hover:underline" href="#">Premium</a></li>
                    <li><a class="hover:underline" href="#">More</a></li>
                </ul>
            </nav>
        </div>

        <div class="flex flex-col gap-6">
            <!-- TODO: This should only display if we are NOT on the posts.index route. -->
            <Link v-show="$page.component !== 'Posts/Index'" :href="route('posts.index')"
                class="bg-pixl hover:bg-pixl/90 active:bg-pixl/95 text-pixl-dark border border-transparent px-4 py-3 text-sm text-center">
            Post
            </Link>

            <!-- User controls -->
            <div class="flex gap-3.5">
                <a :href="route('profiles.show', currentProfile)" class="shrink-0">
                    <img :src="currentProfile.avatar_url"
                        :alt="`Avatar for ${currentProfile.handle}`" class="size-11 object-cover" />
                </a>
                <div class="flex flex-col gap-1 text-sm">
                    <p>{{ currentProfile.display_name }}</p>
                    <p class="text-pixl-light/60">@{{ currentProfile.handle }}</p>
                </div>
                <button class="group flex gap-[3px] py-2" aria-label="Post options">
                    <span class="bg-pixl-light/40 group-hover:bg-pixl-light/60 size-1"></span>
                    <span class="bg-pixl-light/40 group-hover:bg-pixl-light/60 size-1"></span>
                    <span class="bg-pixl-light/40 group-hover:bg-pixl-light/60 size-1"></span>
                </button>
            </div>
        </div>
    </header>
</template>
