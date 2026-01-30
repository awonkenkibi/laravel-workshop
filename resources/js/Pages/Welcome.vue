<script setup>
import Layout from '../Layouts/Layout.vue';

defineProps({
    greeting: ''
});
</script>

<template>
    <Layout>
        <div class="flex-1">
            {{ greeting }}
        </div>
    </Layout>
</template>