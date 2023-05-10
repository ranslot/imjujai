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

function updateLike(like) {
    console.log(like);
}

function deleteSelected(deleteTarget) {
    console.log(deleteTarget);
}

function addComment(comment) {
    console.log(comment);
}
</script>

<template>
    <Head title="Home"></Head>
    <MainLayout>
        <div v-for="post in posts.data" :key="post.id">
            <PostSection
                @openPost="togglePostOverlay"
                @updateLike="updateLike"
                :post="post"
            ></PostSection>
        </div>
    </MainLayout>
    <ShowPostOverlay
        v-if="openOverlay"
        :post="currentPost"
        @closeOverlay="openOverlay = false"
        @deleteSelected="deleteSelected"
        @addComment="addComment"
        @updateLike="updateLike"
    ></ShowPostOverlay>
</template>

<style>
body {
    background-color: rgb(217, 217, 217);
}
</style>
