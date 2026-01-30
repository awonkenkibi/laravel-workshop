<script setup>
import { Form } from '@inertiajs/vue3';
import RepostIcon from './Icons/RepostIcon.vue';

defineProps({
    post: Object
});
</script>

<template>
    <Form method="POST" :action="route('posts.repost', [post.profile, post])">
        <div class="flex items-center gap-1">
            <button aria-label="Re-post" :class="post.has_reposted ? 'text-pixl hover:text-pixl' : ''">
                <RepostIcon />
            </button>

            <span :class="post.has_reposted ? 'text-pixl hover:text-pixl' : ''">{{ post.reposts_count }}</span>
        </div>
    </Form>
</template>