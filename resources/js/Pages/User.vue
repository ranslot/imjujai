<script setup>
import { Head } from "@inertiajs/vue3";
import {
    reactive,
    ref,
    toRefs,
    defineAsyncComponent,
    Suspense,
    computed,
} from "vue";
import MainLayout from "@/Layouts/MainLayout.vue";
import ContentOverlay from "@/Components/ContentOverlay.vue";
import LoadingOverlay from "@/Components/LoadingOverlay.vue";

import { updateLike, addComment, deleteSelected } from "@/Helper/PostHelper.js";
import { updateFollow } from "@/Helper/UserHelper.js";

const ShowPostOverlay = defineAsyncComponent(() =>
    import("@/Components/ShowPostOverlay.vue")
);

const EditUserOverlay = defineAsyncComponent(() =>
    import("@/Components/EditUserOverlay.vue")
);

let data = reactive({ post: null });

let showEditUser = ref(false);

const props = defineProps({
    postByUser: Object,
    user: Object,
    userLikes: Object,
    postsLikes: Object,
    userAuthFollow: Object,
    userFollow: Object,
});
const { postByUser, user, userLikes, userFollow, userAuthFollow, postsLikes } =
    toRefs(props);

function updatePost(Object) {
    data.post = postByUser.value.data.find(
        (post) => post.id === Object.post.id
    );
}

const isFollowed = computed(() => {
    for (let i = 0; i < userAuthFollow.value.length; i++) {
        if (user.value.id === userAuthFollow.value[i].followed_user_id) {
            return true;
        }
    }
    return false;
});

let showPostByUser = ref(true);

//icon
import Grid from "vue-material-design-icons/Grid.vue";
import Cog from "vue-material-design-icons/Cog.vue";
import FoodAppleOutline from "vue-material-design-icons/FoodAppleOutline.vue";
import FoodApple from "vue-material-design-icons/FoodApple.vue";
</script>

<template>
    <Head title="User" />
    <MainLayout>
        <template #userName>
            <h1 class="text-black font-extrabold text-lg">
                {{ user.name }}
            </h1>
        </template>
        <section class="w-full lg:ml-0 md:mx-auto px-4 pt-3 lg:pt-7">
            <article class="flex items-center lg:justify-between md:pb-5 pl-7">
                <img
                    :src="user.file"
                    :alt="user.name"
                    width="200"
                    height="200"
                    class="rounded-full object-contain md:w-[200px] w-[100px]"
                    loading="lazy"
                />
                <div class="ml-6 w-full">
                    <div class="flex items-center md:mb-8 mb-5 gap-3">
                        <p class="md:mr-6 mr-3 rounded-lg text-[22px]">
                            {{ user.name }}
                        </p>

                        <button
                            class="md:flex items-center justify-between gap-3 hidden md:mr-6 p-1 px-4 rounded-lg text-[16px] font-extrabold bg-gray-200 hover:bg-gray-300 text-gray-400"
                            v-if="user.id === $page.props.auth.user.id"
                            @click="showEditUser = true"
                        >
                            Edit Profile
                            <Cog :size="28"></Cog>
                        </button>
                        <button
                            v-else
                            class="p-1 px-2 rounded-md text-[16px] font-extrabold bg-gray-200 hover:bg-gray-300 text-gray-400"
                            @click="updateFollow(user.id, isFollowed)"
                        >
                            <div v-if="isFollowed">Unfollow</div>
                            <div v-else>Follow</div>
                        </button>
                    </div>
                    <button
                        class="md:hidden flex items-center justify-between mr-6 p-1 max-w-[150px] w-full px-4 rounded-lg text-[17px] font-extrabold bg-gray-200 hover:bg-gray-300 text-gray-400"
                        v-if="user.id === $page.props.auth.user.id"
                    >
                        Edit Profile
                        <Cog :size="28"></Cog>
                    </button>
                    <div>{{ user.description }}</div>
                    <div class="md:block hidden">
                        <div class="flex items-center text-[18px]">
                            <p class="mr-6">
                                <span class="font-extrabold">
                                    {{ postByUser.data.length }}
                                </span>
                                posts
                            </p>
                            <p class="mr-6">
                                <span class="font-extrabold">
                                    {{ userFollow.userFollowing.length }}
                                </span>
                                following
                            </p>
                            <p class="mr-6">
                                <span class="font-extrabold">
                                    {{ userFollow.userFollowers.length }}
                                </span>
                                followers
                            </p>
                        </div>
                    </div>
                </div>
            </article>

            <article class="md:hidden">
                <div
                    class="flex items-center justify-evenly border-t border-gray-300 mt-8"
                >
                    <div class="text-center w-1/3 p-3">
                        <p class="font-extrabold">
                            {{ postByUser.data.length }}
                        </p>
                        <p class="text-gray-400 font-semibold -mt-1.5">posts</p>
                    </div>
                    <div class="text-center w-1/3 p-3">
                        <p class="font-extrabold">123</p>
                        <p class="text-gray-400 font-semibold -mt-1.5">
                            followers
                        </p>
                    </div>
                    <div class="text-center w-1/3 p-3">
                        <p class="font-extrabold">456</p>
                        <p class="text-gray-400 font-semibold -mt-1.5">
                            following
                        </p>
                    </div>
                </div>

                <div
                    class="flex items-center justify-between w-full border-t border-gray-300"
                >
                    <div
                        class="flex justify-center w-1/2 p-3"
                        :class="
                            showPostByUser
                                ? 'border-t border-gray-900'
                                : ' hover:border-t hover:border-gray-400 hover:text-gray-500'
                        "
                        @click="showPostByUser = true"
                    >
                        <Grid
                            :size="28"
                            fillColor="#000000"
                            class="cursor-pointer"
                        ></Grid>
                    </div>
                    <div
                        class="flex justify-center w-1/2 p-3"
                        :class="
                            !showPostByUser
                                ? 'border-t border-gray-900'
                                : ' hover:border-t hover:border-gray-400 hover:text-gray-500'
                        "
                        @click="showPostByUser = false"
                    >
                        <FoodAppleOutline
                            :size="30"
                            fillColor="#8E8E8E"
                            class="cursor-pointer"
                        ></FoodAppleOutline>
                    </div>
                </div>
            </article>
        </section>
        <section
            id="ContentSection"
            class="md:pr-1.5 lg:pl-0 px-auto w-[max(600px,vw)]"
        >
            <article class="md:block mt-10 hidden border-t border-gray-300">
                <div
                    class="flex items-center justify-between max-w-[600px] mx-auto font-extrabold text-gray-600"
                >
                    <div
                        class="flex items-center justify-center w-1/2 p-[17px] text-gray-800"
                        :class="
                            showPostByUser
                                ? 'border-t border-gray-900'
                                : ' hover:border-t hover:border-gray-400 hover:text-gray-500'
                        "
                        @click="showPostByUser = true"
                    >
                        <Grid
                            :size="18"
                            fillColor="#000000"
                            class="cursor-pointer"
                        ></Grid>
                        <p class="ml-2 -mb-[1px] text-gray-800">POSTS</p>
                    </div>
                    <div
                        class="flex items-center justify-center w-1/2 p-[17px] text-gray-800"
                        :class="
                            !showPostByUser
                                ? 'border-t border-gray-900'
                                : ' hover:border-t hover:border-gray-400 hover:text-gray-500'
                        "
                        @click="showPostByUser = false"
                    >
                        <FoodAppleOutline
                            :size="20"
                            fillColor="#000000"
                            class="cursor-pointer"
                        ></FoodAppleOutline>
                        <p class="ml-2 -mb-[1px]">LIKES</p>
                    </div>
                </div>
            </article>
            <div
                class="grid md:gap-4 gap-1 md:grid-cols-3 grid-cols-2 relative px-3"
            >
                <div v-if="showPostByUser" v-for="post in postByUser.data">
                    <ContentOverlay
                        :post="post"
                        @selectPost="($event) => (data.post = $event)"
                    ></ContentOverlay>
                </div>
                <div v-if="!showPostByUser" v-for="post in postsLikes.data">
                    <ContentOverlay
                        :post="post"
                        @selectPost="($event) => (data.post = $event)"
                    ></ContentOverlay>
                </div>
            </div>
        </section>
    </MainLayout>
    <Suspense v-if="data.post">
        <template #default>
            <ShowPostOverlay
                :post="data.post"
                :userLikes="userLikes"
                @closeOverlay="data.post = null"
                @deleteSelected="
                    deleteSelected($event, updatePost);
                    if ($event.deleteType === 'Post') {
                        setTimeout(() => (data.post = null), 100);
                    }
                "
                @addComment="addComment($event, updatePost)"
                @updateLike="updateLike($event, userLikes, updatePost)"
                @editSelected="updatePost($event)"
            ></ShowPostOverlay>
        </template>
        <template #fallback>
            <LoadingOverlay></LoadingOverlay>
        </template>
    </Suspense>
    <EditUserOverlay
        v-if="showEditUser"
        :user="user"
        @closeEditPost="showEditUser = false"
    ></EditUserOverlay>
</template>

<style>
body {
    background-color: rgba(243, 244, 246, 1);
}
</style>
