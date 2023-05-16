<script setup>
import { ref, toRefs, onMounted, onUnmounted, defineAsyncComponent } from "vue";
import { usePage, Link } from "@inertiajs/vue3";

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
        <button
            class="absolute right-3 top-3 z-50 basis-full bg-white bg-opacity-25 rounded-xl"
        >
            <Close :size="36" fillColor="#000000"></Close>
        </button>

        <div
            class="flex items-center justify-center flex-wrap z-40"
            @click.stop
        >
            <article
                class="lg:w-[1200px] max-w-[95%] md:max-h-[calc(100%-91px)] max-h-full rounded-xl m-auto"
            >
                <div
                    class="w-full h-full md:flex rounded-xl overflow-auto m-auto"
                >
                    <!-- Image -->
                    <div
                        class="flex items-center justify-center bg-gray-300 bg-opacity-40 aspect-square lg:w-[600px] lg:h-[600px] max-w-[600px] max-h-[600px]"
                    >
                        <img
                            :src="post.file"
                            :alt="post.file"
                            width="600"
                            height="600"
                            class="aspect-square"
                        />
                    </div>

                    <!-- Description + Comments -->
                    <div
                        class="relative lg:w-[600px] max-w-[600px] md:h-[600px] h-[300px] bg-white"
                    >
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
                                <p
                                    class="ml-2 flex items-center text-gray-400 sm:text-sm text-xs"
                                >
                                    {{ post.created_at }}
                                </p>
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
                        </div>
                        <div class="overflow-y-auto h-[calc(100%-170px)]">
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
                                            Ate
                                        </div>
                                        <div
                                            class="bg-orange-200 border-red-300 font-extrabold border-2 py-1 px-2 -mt-[6px] rounded-xl"
                                            v-if="post.eat_or_cook === 1"
                                        >
                                            Cooked
                                        </div>
                                        <p>
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
                            @clickComment="textarea.select()"
                            @like="emit('updateLike', $event)"
                        ></LikeSection>

                        <!-- Add Comment-->
                        <div
                            class="absolute flex border-t bottom-0 w-full max-h-[230px] min-h-[36px] bg-white overflow-auto"
                        >
                            <textarea
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
                                Post
                            </button>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </section>
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
