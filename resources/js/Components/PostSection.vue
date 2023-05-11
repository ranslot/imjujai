<script setup>
import { Link } from "@inertiajs/vue3";
import { ref, toRefs, defineAsyncComponent } from "vue";
import LikeSection from "@/Components/LikeSection.vue";

defineEmits(["openPost", "updateLike"]);

const props = defineProps({ post: Object, userLikes: Object });
const { post, userLikes } = toRefs(props);

//icon
import DotsHorizontal from "vue-material-design-icons/DotsHorizontal.vue";
</script>

<template>
    <section
        id="Posts"
        class="max-w-[570px] mx-auto pb-3 mb-5 bg-white rounded-xl"
    >
        <article class="flex items-center justify-between py-2 px-4">
            <div class="flex items-center">
                <Link
                    :href="route('users.show', { id: post.user.id })"
                    class="flex items-center"
                >
                    <img
                        :src="post.user.file"
                        class="rounded-full w-[38px] h-[38px]"
                    />
                    <h3 class="ml-4 font-extrabold text-sm sm:text-base">
                        {{ post.user.name }}
                    </h3>
                </Link>
                <p
                    class="flex items-center pl-2 text-gray-400 text-xs sm:text-sm"
                >
                    {{ post.created_at }}
                </p>
            </div>
            <DotsHorizontal class="cursor-pointer" :size="27"></DotsHorizontal>
        </article>
        <article
            class="rounded w-full h-fit flex items-center overflow-hidden cursor-pointer"
            @click="$emit('openPost', post)"
        >
            <img
                class="mx-auto w-full h-fit object-scale-down"
                :src="post.file"
            />
        </article>
        <article class="px-4">
            <LikeSection
                :post="post"
                :userLikes="userLikes"
                @like="$emit('updateLike', $event)"
            ></LikeSection>
            <h4 class="text-black font-extrabold text-sm py-1.5">
                {{ post.likes.length == 0 ? "No" : post.likes.length }} likes
            </h4>
            <p class="text-sm">
                <span class="text-black font-extrabold">{{
                    post.user.name
                }}</span>
                {{ post.text }}
            </p>
            <button
                class="text-gray-400 font-extrabold py-1.5"
                @click="$emit('openPost', post)"
            >
                <div v-if="post.comments.length == 0">Add comment</div>
                <div v-else>View all {{ post.comments.length }} comments</div>
            </button>
        </article>
    </section>
</template>
