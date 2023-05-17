<script setup>
import { Head, usePage } from "@inertiajs/vue3";
import { ref, toRefs, defineAsyncComponent, Suspense, computed } from "vue";

import { updateLike, addComment, deleteSelected } from "@/Helper/PostHelper.js";

import MainLayout from "@/Layouts/MainLayout.vue";
import PostSection from "@/Components/PostSection.vue";
import LoadingOverlay from "@/Components/LoadingOverlay.vue";

const ShowPostOverlay = defineAsyncComponent(() =>
    import("@/Components/ShowPostOverlay.vue")
);

const props = defineProps({
    posts: Object,
    userLikes: Object,
    userAuthFollow: Object,
});
const { posts, userLikes, userAuthFollow } = toRefs(props);

let currentPost = ref(null);
let openOverlay = ref(false);

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

const searchValue = computed(() => {
    if (page.includes("search")) {
        return page.split("=")[1];
    }
});

let postByFollows = ref([]);
let allPost = ref(true);

function postByFollowUsers() {
    if (postByFollows.value.length > 0) {
        allPost.value = false;
        return;
    }

    const followMap = new Map();
    for (let i = 0; i < userAuthFollow.value.length; i++) {
        followMap.set(userAuthFollow.value[i].followed_user_id, 1);
    }

    for (let j = 0; j < posts.value.data.length; j++) {
        if (followMap.get(posts.value.data[j].user.id) === 1) {
            postByFollows.value.push(posts.value.data[j]);
        }
    }

    allPost.value = false;
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
        <div
            class="grid grid-flow-col grid-cols-2 items-center justify-stretch w-full mb-1"
            v-if="!page.includes('search')"
        >
            <h2
                class="px-10 py-3 text-lg text-center font-extrabold truncate rounded-l-lg"
                :class="
                    allPost
                        ? 'bg-orange-300 border-2 border-orange-500'
                        : 'hover:bg-orange-200 hover:border-2 border-orange-500'
                "
                @click="allPost = true"
            >
                All Photo
            </h2>
            <h2
                class="px-10 py-3 text-lg text-center font-extrabold truncate rounded-r-lg"
                :class="
                    !allPost
                        ? 'bg-orange-300 border-2 border-orange-500'
                        : 'hover:bg-orange-200 hover:border-2 border-orange-500'
                "
                @click="postByFollowUsers"
            >
                Following
            </h2>
        </div>
        <div v-if="allPost" v-for="post in posts.data" :key="post.id">
            <PostSection
                @openPost="togglePostOverlay($event)"
                @updateLike="updateLike($event, userLikes, updatePost)"
                :userLikes="userLikes"
                :post="post"
            ></PostSection>
        </div>

        <div
            v-else-if="postByFollows.length > 0"
            v-for="postByFollow in postByFollows"
            :key="postByFollow.id"
        >
            <PostSection
                @openPost="togglePostOverlay($event)"
                @updateLike="updateLike($event, userLikes, updatePost)"
                :userLikes="userLikes"
                :post="postByFollow"
            ></PostSection>
        </div>
        <div
            v-else="postByFollows.length === 0"
            class="text-lg font-extrabold py-5 max-w-[570px] w-full"
        >
            Users you followed didn't have any photo 😭😭
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
                @editSelected="updatePost($event)"
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
