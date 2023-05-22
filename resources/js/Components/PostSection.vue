<script setup>
import { Link } from "@inertiajs/vue3";
import { ref, toRefs } from "vue";
import LikeSection from "@/Components/LikeSection.vue";
import LoadingOverlay from "@/Components/LoadingOverlay.vue";

defineEmits(["openPost", "updateLike"]);

const props = defineProps({ post: Object, userLikes: Object });
const { post, userLikes } = toRefs(props);

let searchPost = ref(false);

if (searchPost.value) {
    setTimeout(() => {
        searchPost.value = false;
    }, 5000);
}
</script>

<template>
    <section
        id="Posts"
        class="max-w-[570px] mx-auto pb-3 mb-5 bg-white rounded-xl shadow-lg shadow-orange-200"
    >
        <article class="flex items-center py-2 px-4">
            <div class="flex items-center w-full justify-between">
                <Link
                    :href="route('users.show', { id: post.user.id })"
                    class="flex items-center"
                >
                    <img
                        :src="post.user.file"
                        width="38"
                        height="38"
                        class="rounded-full w-[38px] h-[38px]"
                        :alt="post.user.name"
                        loading="lazy"
                    />
                    <h3 class="ml-4 font-extrabold text-sm sm:text-base">
                        {{ post.user.name }}
                    </h3>
                </Link>
            </div>
        </article>
        <article
            class="rounded w-full h-fit flex items-center overflow-hidden cursor-pointer"
            @click="$emit('openPost', post)"
        >
            <img
                class="mx-auto w-full h-fit object-scale-down"
                :src="post.file"
                :alt="post.file"
                loading="lazy"
                draggable="false"
            />
        </article>
        <article class="px-4">
            <LikeSection
                :post="post"
                :userLikes="userLikes"
                @like="$emit('updateLike', $event)"
                @clickComment="$emit('openPost', post)"
            ></LikeSection>
            <h4 class="text-black font-extrabold text-sm py-1.5">
                {{ post.likes.length == 0 ? "No" : post.likes.length }} likes
            </h4>
            <div class="text-sm flex gap-1">
                <span class="text-black font-extrabold">{{
                    post.user.name
                }}</span>
                <div
                    class="bg-orange-200 border-red-300 font-extrabold border-2 py-1 px-2 -mt-[6px] rounded-xl"
                    v-if="post.eat_or_cook === 0"
                >
                    ได้กิน
                </div>
                <div
                    class="bg-orange-200 border-red-300 font-extrabold border-2 py-1 px-2 -mt-[6px] rounded-xl"
                    v-if="post.eat_or_cook === 1"
                >
                    ได้ปรุง
                </div>
                <p class="truncate">
                    {{ post.text }}
                </p>
            </div>
            <div class="flex flex-row text-sm">
                <div
                    v-if="post.tags"
                    v-for="tag in post.tags.split(',')"
                    class="pr-2"
                >
                    <Link
                        class="text-blue-500 hover:text-blue-400"
                        href="/"
                        :data="{ search: tag }"
                        @click="searchPost = true"
                        >#{{ tag }}</Link
                    >
                </div>
            </div>

            <button
                class="text-gray-400 font-extrabold py-1.5"
                @click="$emit('openPost', post)"
            >
                <div v-if="post.comments.length == 0">เพิ่มคอมเมนต์</div>
                <div v-else>ดู {{ post.comments.length }} คอมเมนต์</div>
            </button>
        </article>
    </section>
    <LoadingOverlay v-if="searchPost"></LoadingOverlay>
</template>
