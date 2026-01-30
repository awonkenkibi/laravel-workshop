<script setup>
import { usePage } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

let flashMessage = ref('');
let show = ref(false);

function flash(message) {
    flashMessage.value = message;
    show.value = true;

    setTimeout(() => show.value = false, 4000);
}

watch(() => usePage().props.flash.success, flash);
</script>

<template>
    <Transition enter-active-class="transition duration-300 transform ease-out"
        enter-from-class="translate-x-full opacity-0" enter-to-class="opacity-100"
        leave-active-class="transition duration-200 transform ease-out" leave-from-class="opacity-100"
        leave-to-class="translate-x-full opacity-0">
        <div v-if="flashMessage && show" class="fixed bottom-4 right-4 bg-pixl text-white rounded-md py-2 px-3"
            v-text="flashMessage" />
    </Transition>
</template>