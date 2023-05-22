<script setup>
import {
    ref,
    toRefs,
    onMounted,
    onUnmounted,
    defineAsyncComponent,
    computed,
} from "vue";
import { usePage, Link } from "@inertiajs/vue3";

import "@/style/animation.css";
import FadedBackgroundLayout from "@/Layouts/FadedBackgroundLayout.vue";

import LikeSection from "@/Components/LikeSection.vue";
import CommentsSection from "@/Components/CommentsSection.vue";

const SettingPostOverlay = defineAsyncComponent(() =>
    import("@/Components/SettingPostOverlay.vue")
);
const EditPostOverlay = defineAsyncComponent(() =>
    import("@/Components/EditPostOverlay.vue")
);

const user = usePage().props.auth.user;

let textarea = ref(null);
let comment = ref("");
let deleteType = ref(null);
let showEditOverlay = ref(false);
let id = ref(null);

const props = defineProps({ post: Object, userLikes: Object });
const { post, userLikes } = toRefs(props);

const emit = defineEmits([
    "closeOverlay",
    "addComment",
    "updateLike",
    "deleteSelected",
    "editSelected",
]);

const postComments = computed(() => {
    return [...post.value.comments].reverse();
});

const closeOnEscape = (e) => {
    if (e.key === "Escape") {
        emit("closeOverlay");
    }
};

onMounted(() => document.addEventListener("keydown", closeOnEscape));

onUnmounted(() => document.removeEventListener("keydown", closeOnEscape));

function textareaInput(e) {
    textarea.value.style.height = "auto";
    textarea.value.style.height = `${e.target.scrollHeight}px`;
}

function deleteTargetHandle(type, targetId) {
    deleteType.value = type;
    id.value = targetId;
}

let searchPost = ref(false);

if (searchPost.value) {
    setTimeout(() => {
        searchPost.value = false;
    }, 5000);
}

function gotoComment() {
    textarea.value.select();
    document
        .getElementById("addComment")
        .scrollIntoView({ behavior: "smooth" });
}

//icon
import DotsHorizontal from "vue-material-design-icons/DotsHorizontal.vue";
import Close from "vue-material-design-icons/Close.vue";
</script>

<template>
    <FadedBackgroundLayout
        @click="emit('closeOverlay')"
        class="min-h-0 min-w-0"
    >
        <button
            class="absolute right-3 top-3 z-50 basis-full bg-white bg-opacity-25 rounded-xl cursor-pointer"
        >
            <Close :size="36" fillColor="#000000"></Close>
        </button>
        <div
            id="ShowPostOverlay"
            class="flex items-center justify-center flex-wrap z-40 transform-gpu transition scale-in min-h-0 min-w-0"
            @click.stop
        >
            <article
                class="md:w-[1200px] md:max-h-[calc(100%-100px)] md:aspect-auto aspect-[1/2] max-h-[700px] mx-auto rounded-xl"
            >
                <div
                    class="md:flex rounded-xl overflow-auto relative min-h-0 min-w-0"
                >
                    <!-- Image -->
                    <div
                        class="flex items-center justify-center bg-gray-300 bg-opacity-40 aspect-square max-w-[600px] max-h-[600px]"
                    >
                        <img
                            :src="post.file"
                            :alt="post.file"
                            width="600"
                            height="600"
                            class="aspect-square"
                            loading="lazy"
                            draggable="false"
                        />
                    </div>

                    <!-- Description + Comments -->
                    <div
                        class="max-w-[600px] aspect-square w-full relative bg-white flex flex-col justify-between min-h-0 min-w-0"
                    >
                        <div>
                            <div
                                class="flex items-center justify-between p-3 border-b"
                            >
                                <div class="flex items-center">
                                    <img
                                        :src="post.user.file"
                                        :alt="post.user.name"
                                        width="38"
                                        height="38"
                                        class="rounded-full w-[38px] h-[38px]"
                                        loading="lazy"
                                    />
                                    <h3
                                        class="ml-4 font-extrabold sm:text-base text-sm"
                                    >
                                        {{ post.user.name }}
                                    </h3>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button
                                        v-if="user.id === post.user.id"
                                        class="cursor-pointer"
                                        @click.prevent="
                                            deleteTargetHandle('โพสต์', post.id)
                                        "
                                    >
                                        <DotsHorizontal
                                            :size="27"
                                        ></DotsHorizontal>
                                    </button>
                                </div>
                            </div>

                            <LikeSection
                                class="px-5 border-b pb-3 flex md:hidden"
                                v-if="post"
                                :post="post"
                                :userLikes="userLikes"
                                @clickComment="gotoComment"
                                @like="emit('updateLike', $event)"
                            ></LikeSection>
                        </div>

                        <div class="overflow-y-auto flex-grow">
                            <div class="flex items-center justify-between p-3">
                                <div
                                    class="flex items-center w-full relative flex-wrap"
                                >
                                    <img
                                        :src="post.user.file"
                                        :alt="post.user.name"
                                        class="absolute rounded-full w-[38px] h-[38px] -top-1"
                                    />

                                    <div class="flex gap-2 ml-[50px] mt-1">
                                        <span
                                            class="text-black font-extrabold"
                                            >{{ post.user.name }}</span
                                        >
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
                                            class="px-2"
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
                                </div>
                            </div>
                            <div
                                class="py-1 px-3"
                                v-for="comment in postComments"
                                :key="comment.id"
                            >
                                <CommentsSection
                                    :comment="comment"
                                    :user="user"
                                    @deleteComment="deleteTargetHandle"
                                ></CommentsSection>
                            </div>
                        </div>

                        <LikeSection
                            class="px-5 border-t pb-3 hidden md:flex"
                            v-if="post"
                            :post="post"
                            :userLikes="userLikes"
                            @clickComment="textarea.select()"
                            @like="emit('updateLike', $event)"
                        ></LikeSection>

                        <!-- Add Comment-->
                        <div
                            class="sticky flex border-t bottom-0 w-full max-h-[230px] min-h-[57px] bg-white overflow-auto"
                        >
                            <textarea
                                id="addComment"
                                ref="textarea"
                                :onInput="textareaInput"
                                v-model="comment"
                                placeholder="Add new comment. . ."
                                rows="1"
                                class="w-full z-50 text-xs sm:text-sm mt-2 mb-2 border-0 focus:ring-0 text-gray-600 resize-none mx-3"
                            ></textarea>
                            <button
                                v-if="comment"
                                class="text-blue-400 font-extrabold pr-4"
                                @click="
                                    emit('addComment', {
                                        post,
                                        user,
                                        comment,
                                    });
                                    textarea.style.height = 'auto';
                                    comment = '';
                                "
                            >
                                โพสต์
                            </button>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </FadedBackgroundLayout>
    <LoadingOverlay v-if="searchPost"></LoadingOverlay>
    <SettingPostOverlay
        v-if="deleteType"
        :deleteType="deleteType"
        :id="id"
        @closeSettingPost="
            deleteType = null;
            id = null;
        "
        @editShow="
            showEditOverlay = true;
            deleteType = null;
            id = null;
        "
        @deleteSelected="
            emit('deleteSelected', {
                deleteType: deleteType,
                id: id,
                post: post,
            });
            deleteType = null;
            id = null;
        "
    ></SettingPostOverlay>
    <EditPostOverlay
        v-if="showEditOverlay"
        @editSelected="
            emit('editSelected', {
                post: post,
            })
        "
        @closeEditPost="showEditOverlay = null"
        :post="post"
    ></EditPostOverlay>
</template>
