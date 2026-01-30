<script setup lang="ts">
import BookmarkIcon from './Icons/BookmarkIcon.vue';

</script>

<template>
    <div class="flex items-center gap-1">
        <button aria-label="Save" class="hover:text-pixl">
            <BookmarkIcon />
        </button>

        <span class="text-pixl-light/40 text-sm">Save</span>
    </div>
</template>