<script setup>
import AppFooter from '../../Components/AppFooter.vue';
import Post from '../../Components/Post.vue';
import Layout from '../../Layouts/Layout.vue';

defineProps({
    post: Object
});
</script>

<template>
    <Layout>
        <!-- Content -->
        <main class="-mx-4 flex grow flex-col gap-4 overflow-y-auto px-4 py-4">
            <div>
                <nav class="overflow-x-auto [scrollbar-width:none]">
                    <ul class="flex min-w-max justify-end gap-8 text-sm">
                        <li><a href="#">For you</a></li>
                        <li>
                            <a class="text-pixl-light/60 hover:text-pixl-light/80" href="#">Idea streams</a>
                        </li>
                        <li>
                            <a class="text-pixl-light/60 hover:text-pixl-light/80" href="#">Following</a>
                        </li>
                    </ul>
                </nav>
            </div>

            <ol class="mt-4">
                <Post :post="post" :show-replies="true" />
            </ol>

            <AppFooter />
        </main>
    </Layout>
</template>
