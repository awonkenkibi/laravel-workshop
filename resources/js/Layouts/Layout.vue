<script setup lang="ts">
import Aside from '../Components/Aside.vue';
import FlashMessages from '../Components/FlashMessages.vue';
import Navigation from '../Components/Navigation.vue';

</script>

<template>
    <div class="bg-pixl-dark text-pixl-light flex gap-8 px-4 sm:h-dvh sm:overflow-clip xl:gap-16">
        <Navigation />

        <slot />

        <Aside />

        <FlashMessages />
    </div>
</template>