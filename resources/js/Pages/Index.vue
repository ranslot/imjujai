<script setup>
import { Head, router } from "@inertiajs/vue3";
import { ref, toRefs, defineAsyncComponent, Suspense } from "vue";

import MainLayout from "@/Layouts/MainLayout.vue";
import PostSection from "@/Components/PostSection.vue";

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

function updateLike(like) {
    let deleteLike = false;
    let id = null;

    for (let i = 0; i < userLikes.value.length; i++) {
        if (like.post.id === userLikes.value[i].post_id) {
            deleteLike = true;
            id = userLikes.value[i].id;
        }
    }

    if (deleteLike) {
        router.delete(`/likes/${id}`, {
            onFinish: () => updatePost(like),
        });
    } else {
        router.post(
            "/likes",
            {
                post_id: like.post.id,
            },
            {
                onFinish: () => updatePost(like),
            }
        );
    }
}

function deleteSelected(deleteTarget) {
    if (deleteTarget.deleteType === "Post") {
        router.delete(`/posts/${deleteTarget.id}`, {
            onFinish: () => updatePost(deleteTarget),
        });
        openOverlay = false;
    }

    if (deleteTarget.deleteType === "Comment") {
        router.delete(`/comments/${deleteTarget.id}`, {
            onFinish: () => updatePost(deleteTarget),
        });
    }
}

function addComment(newComment) {
    router.post(
        "/comments",
        {
            post_id: newComment.post.id,
            user_id: newComment.user.id,
            comment: newComment.comment,
        },
        {
            onFinish: () => updatePost(newComment),
        }
    );
}
</script>

<template>
    <Head title="Home"></Head>
    <MainLayout>
        <div v-for="post in posts.data" :key="post.id">
            <PostSection
                @openPost="togglePostOverlay($event)"
                @updateLike="updateLike($event)"
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
                @deleteSelected="deleteSelected($event)"
                @addComment="addComment($event)"
                @updateLike="updateLike($event)"
            ></ShowPostOverlay>
        </template>
        <template #fallback>
            <div
                class="fixed flex justify-center items-center z-50 w-full h-screen bg-black bg-opacity-60 top-0 left-0"
            >
                <div
                    class="animate-spin rounded-full h-24 w-24 border-t-4 border-b-4 border-l-4 border-yellow-300 z-50"
                ></div>
            </div>
        </template>
    </Suspense>
</template>

<style>
body {
    background-color: rgb(217, 217, 217);
}
</style>
