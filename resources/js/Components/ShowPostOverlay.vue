<script setup>
import { ref, toRefs, onMounted, onUnmounted, defineAsyncComponent } from "vue";
import { usePage } from "@inertiajs/vue3";

import LikeSection from "@/Components/LikeSection.vue";
import CommentsSection from "@/Components/CommentsSection.vue";

const SettingPostOverlay = defineAsyncComponent(() =>
    import("@/Components/SettingPostOverlay.vue")
);

const user = usePage().props.auth.user;

let textarea = ref(null);
let comment = ref("");
let deleteType = ref(null);
let id = ref(null);

const props = defineProps({ post: Object, userLikes: Object });
const { post, userLikes } = toRefs(props);

const emit = defineEmits([
    "closeOverlay",
    "addComment",
    "updateLike",
    "deleteSelected",
]);

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

//icon
import Close from "vue-material-design-icons/Close.vue";
import EmoticonHappyOutline from "vue-material-design-icons/EmoticonHappyOutline.vue";
import DotsHorizontal from "vue-material-design-icons/DotsHorizontal.vue";
</script>

<template>
    <section
        id="OverlaySection"
        class="fixed z-30 top-0 left-0 w-full h-screen bg-black bg-opacity-60 p-3 overflow-auto flex items-center justify-center flex-wrap"
        @click="emit('closeOverlay')"
    >
        <button class="absolute right-3 top-3 z-50 basis-full">
            <Close :size="36" fillColor="#FFFFFF"></Close>
        </button>

        <div
            class="flex items-center justify-center flex-wrap z-40"
            @click.stop
        >
            <article
                class="md:max-w-6xl max-w-[92%] md:max-h-[calc(100%-100px)] max-h-full rounded-xl m-auto"
            >
                <div
                    class="w-full h-full md:flex rounded-xl overflow-auto m-auto"
                >
                    <!-- Image -->
                    <div
                        class="flex items-center justify-center max-w-[720px] max-h-[720px] bg-gray-300 bg-opacity-50"
                    >
                        <img class="" :src="post.file" />
                    </div>

                    <!-- Description + Comments -->
                    <div
                        class="w-full relative md:max-w-[400px] md:h-[600px] h-[300px] bg-white"
                    >
                        <div
                            class="flex items-center justify-between p-3 border-b"
                        >
                            <div class="flex items-center">
                                <img
                                    :src="post.user.file"
                                    class="rounded-full w-[38px] h-[38px]"
                                />
                                <h3
                                    class="ml-4 font-extrabold sm:text-base text-sm"
                                >
                                    {{ post.user.name }}
                                </h3>
                                <p
                                    class="ml-2 flex items-center text-gray-500 sm:text-sm text-xs"
                                >
                                    {{ post.created_at }}
                                </p>
                            </div>
                            <button
                                v-if="user.id === post.user.id"
                                class="cursor-pointer"
                                @click.prevent="
                                    deleteTargetHandle('Post', post.id)
                                "
                            >
                                <DotsHorizontal :size="27"></DotsHorizontal>
                            </button>
                        </div>
                        <div class="overflow-y-auto h-[calc(100%-170px)]">
                            <div class="flex items-center justify-between p-3">
                                <div class="flex items-center relative">
                                    <img
                                        :src="post.user.file"
                                        class="absolute rounded-full w-[38px] h-[38px] -top-1"
                                    />

                                    <p class="ml-14 mt-1">
                                        <span
                                            class="font-extrabold sm:text-base text-sm mr-2"
                                        >
                                            {{ post.user.name }}
                                        </span>
                                        <span
                                            class="text-gray-800 sm:text-base text-sm"
                                        >
                                            {{ post.text }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                            <div
                                class="py-1 px-3"
                                v-for="comment in post.comments"
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
                            class="px-5 border-t mb-[60px]"
                            v-if="post"
                            :post="post"
                            :userLikes="userLikes"
                            @like="$emit('updateLike', $event)"
                        ></LikeSection>

                        <!-- Add Comment-->
                        <div
                            class="absolute flex border-t bottom-0 w-full max-h-[230px] min-h-[36px] bg-white overflow-auto"
                        >
                            <EmoticonHappyOutline
                                class="pt-[10px] pl-3"
                                :size="30"
                            ></EmoticonHappyOutline>
                            <textarea
                                ref="textarea"
                                :onInput="textareaInput"
                                v-model="comment"
                                placeholder="Add comment. . ."
                                rows="1"
                                class="w-full z-50 text-xs sm:text-sm mt-2 mb-2 border-0 focus:ring-0 text-gray-600 resize-none"
                            ></textarea>
                            <button
                                v-if="comment"
                                class="text-blue-400 font-extrabold pr-4"
                                @click="
                                    $emit('addComment', {
                                        post,
                                        user,
                                        comment,
                                    });
                                    comment = '';
                                "
                            >
                                Post
                            </button>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </section>
    <SettingPostOverlay
        v-if="deleteType"
        :deleteType="deleteType"
        :id="id"
        @closeSettingPost="
            deleteType = null;
            id = null;
        "
        @deleteSelected="
            $emit('deleteSelected', {
                deleteType: deleteType,
                id: id,
                post: post,
            });
            deleteType = null;
            id = null;
        "
    ></SettingPostOverlay>
</template>
