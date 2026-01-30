<script setup>
import LikeButton from './LikeButton.vue';
import ReplyButton from './ReplyButton.vue';
import RepostButton from './RepostButton.vue';
import SaveButton from './SaveButton.vue';
import ShareButton from './ShareButton.vue';
import Reply from './Reply.vue';
import ReplyForm from './ReplyForm.vue';
import { ref } from 'vue';
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { Link } from '@inertiajs/vue3';

defineProps({
    post: Object,
    showEngagement: { type: Boolean, default: true },
    showReplies: { type: Boolean, default: false },
});

let showReplyForm = ref(false);
</script>

<template>
    <li class="flex items-start gap-4 not-first:pt-2.5" data-test="post-feed-item">
        <a :href="route('profiles.show', post.profile)" class="shrink-0">
            <img :src="post.profile.avatar_url" :alt="`Avatar for ${post.profile.display_name}`"
                class="size-10 object-cover" />
        </a>

        <div class="grow pt-1.5">
            <div class="border-pixl-light/10 border-b pb-5">
                <!-- User meta -->
                <div class="flex items-center justify-between gap-4">
                    <div class="flex items-center gap-2.5">
                        <p>
                            <a class="hover:underline" :href="route('profiles.show', post.profile)">{{
                                post.profile.display_name }}</a>
                        </p>

                        <p class="text-pixl-light/40 text-xs">
                            <a :href="route('posts.show', [post.profile, post])" data-test="visit-post-link">{{
                                post.created_at }}</a>
                        </p>

                        <p>
                            <a class="text-pixl-light/40 hover:text-pixl-light/60 text-xs"
                                :href="route('profiles.show', post.profile)">{{ post.profile.handle }}</a>
                        </p>
                    </div>

                    <Menu as="div" class="relative inline-block">
                        <MenuButton
                            class="group flex gap-[3px] py-2 w-full justify-center rounded-md px-3 text-sm font-semibold text-white inset-ring-1 inset-ring-white/5">
                            <span class="bg-pixl-light/40 group-hover:bg-pixl-light/60 size-1"></span>
                            <span class="bg-pixl-light/40 group-hover:bg-pixl-light/60 size-1"></span>
                            <span class="bg-pixl-light/40 group-hover:bg-pixl-light/60 size-1"></span>
                        </MenuButton>

                        <transition enter-active-class="transition ease-out duration-100"
                            enter-from-class="transform opacity-0 scale-95" enter-to-class="transform scale-100"
                            leave-active-class="transition ease-in duration-75" leave-from-class="transform scale-100"
                            leave-to-class="transform opacity-0 scale-95">
                            <MenuItems
                                class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-pixl-dark outline-1 -outline-offset-1 outline-white/10">
                                <div class="py-1">
                                    <MenuItem v-slot="{ active }">
                                    <Link :href="route('posts.show', [post.profile, post])"
                                        class="block px-4 py-2 text-sm">View Post</Link>
                                    </MenuItem>

                                    <MenuItem v-slot="{ active }" v-if="post.can.update">
                                    <Link :href="route('posts.destroy', [post.profile, post])" method="post" as="button"
                                        class="block px-4 py-2 text-sm">Delete</Link>
                                    </MenuItem>
                                </div>
                            </MenuItems>
                        </transition>
                    </Menu>
                </div>

                <!-- Post content -->
                <div class="[&_a]:text-pixl mt-4 flex flex-col gap-3 text-sm [&_a]:hover:underline">
                    <div v-html="post.content"></div>

                    <ul v-if="!!post.repost_of">
                        <Post :post="post.repost_of" :show-engagement="false" />
                    </ul>
                </div>

                <div v-if="showEngagement" class="mt-6 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-8">
                        <LikeButton :post="post" />
                        <ReplyButton :count="post.replies_count" :id="post.id" @click="showReplyForm = true" />
                        <RepostButton :post="post" />
                    </div>

                    <div class="flex items-center gap-3">
                        <SaveButton :id="post.id" />
                        <ShareButton :id="post.id" />
                    </div>
                </div>

                <ReplyForm v-show="showReplyForm" :post="post" :profile="$page.props.auth.user.profile"
                    @success="showReplyForm = false" />
            </div>

            <ol v-if="showReplies">
                <Reply v-for="reply in post.replies" :key="post.id" :post="reply" :show-engagement="showEngagement"
                    :show-replies="showReplies" />
            </ol>
        </div>
    </li>
</template>