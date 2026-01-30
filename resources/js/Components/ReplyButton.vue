<script setup>
import CommentIcon from './Icons/CommentIcon.vue';

defineProps({ count: { type: Number, default: 0 } });
</script>

<template>
    <div class="flex items-center gap-1">
        <button aria-label="Comment" class="hover:text-pixl">
            <CommentIcon />
        </button>
        <span class="text-sm">{{ count }}</span>
    </div>
</template>