<script setup>
import { Head, usePage } from "@inertiajs/vue3";
import { ref, toRefs, defineAsyncComponent, Suspense } from "vue";

import {
    updateLike,
    addComment,
    deleteSelected,
    editPost,
} from "@/Helper/PostHelper.js";

import MainLayout from "@/Layouts/MainLayout.vue";
import PostSection from "@/Components/PostSection.vue";
import LoadingOverlay from "@/Components/LoadingOverlay.vue";

const ShowPostOverlay = defineAsyncComponent(() =>
    import("@/Components/ShowPostOverlay.vue")
);

let currentPost = ref(null);
let openOverlay = ref(false);

const props = defineProps({ posts: Object, userLikes: Object });
const { posts, userLikes } = toRefs(props);

function togglePostOverlay(post) {
    openOverlay.value = true;
    currentPost.value = post;
}

function updatePost(Object) {
    currentPost.value = posts.value.data.find(
        (post) => post.id === Object.post.id
    );
}

const page = usePage().url;
let searchValue = ref("");
if (page.includes("search")) {
    searchValue.value = page.split("=")[1];
}
</script>

<template>
    <Head title="Home"></Head>
    <MainLayout>
        <template #search>
            <div v-if="page.includes('search')">
                <h1 class="font-extrabold text-lg">
                    Search : {{ searchValue }}
                </h1>
            </div>
        </template>
        <div v-for="post in posts.data" :key="post.id">
            <PostSection
                @openPost="togglePostOverlay($event)"
                @updateLike="updateLike($event, userLikes, updatePost)"
                :userLikes="userLikes"
                :post="post"
            ></PostSection>
        </div>
    </MainLayout>
    <Suspense v-if="openOverlay">
        <template #default>
            <ShowPostOverlay
                :post="currentPost"
                :userLikes="userLikes"
                @closeOverlay="openOverlay = false"
                @deleteSelected="
                    deleteSelected($event, updatePost);
                    if ($event.deleteType === 'Post') {
                        openOverlay = false;
                        currentPost = null;
                    }
                "
                @addComment="addComment($event, updatePost)"
                @updateLike="updateLike($event, userLikes, updatePost)"
                @editSelected="($event) => updatePost($event)"
            ></ShowPostOverlay>
        </template>
        <template #fallback> <LoadingOverlay></LoadingOverlay> </template>
    </Suspense>
</template>

<style>
body {
    background-color: rgb(217, 217, 217);
}
</style>
