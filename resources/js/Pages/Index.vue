<script setup>
import { Head, router, usePage } from "@inertiajs/vue3";
import { ref, toRefs, defineAsyncComponent, Suspense } from "vue";

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
        openOverlay.value = false;
        currentPost.value = null;
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
        <template #fallback> <LoadingOverlay></LoadingOverlay> </template>
    </Suspense>
</template>

<style>
body {
    background-color: rgb(217, 217, 217);
}
</style>
