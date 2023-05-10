<script setup>
import { Head, Link } from "@inertiajs/vue3";
import { ref, toRefs, defineAsyncComponent } from "vue";
import MainLayout from "@/Layouts/MainLayout.vue";
import PostSection from "@/Components/PostSection.vue";

const ShowPostOverlay = defineAsyncComponent(() =>
    import("@/Components/ShowPostOverlay.vue")
);

let currentPost = ref(null);
let openOverlay = ref(false);

const props = defineProps({ posts: Object });
const { posts } = toRefs(props);

function togglePostOverlay(post) {
    openOverlay.value = true;
    currentPost = post;
}
</script>

<template>
    <Head title="Home"></Head>
    <MainLayout>
        <div v-for="post in posts.data">
            <PostSection
                @openPost="togglePostOverlay"
                :post="post"
            ></PostSection>
        </div>
    </MainLayout>
    <ShowPostOverlay
        v-if="openOverlay"
        :post="currentPost"
        @closeOverlay="openOverlay = false"
    ></ShowPostOverlay>
</template>

<style>
body {
    background-color: rgb(217, 217, 217);
}
</style>
