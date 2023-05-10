<script setup>
import { ref, toRefs, onMounted, onUnmounted, defineAsyncComponent } from "vue";
import { usePage } from "@inertiajs/vue3";

import LikeSection from "@/Components/LikeSection.vue";

const SettingPostOverlay = defineAsyncComponent(() =>
    import("@/Components/SettingPostOverlay.vue")
);

const user = usePage().props.auth.user;

let textarea = ref(null);
let comments = ref("");
let comment = ref("");
let deleteType = ref(null);
let id = ref(null);

const props = defineProps({ post: Object });
const { post } = toRefs(props);

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

onUnmounted(() => {
    document.removeEventListener("keydown", closeOnEscape);
});

function textareaInput(e) {
    textarea.value.style.height = "auto";
    textarea.value.style.height = `${e.target.scrollHeight}px`;
}

//icon
import Close from "vue-material-design-icons/Close.vue";
import EmoticonHappyOutline from "vue-material-design-icons/EmoticonHappyOutline.vue";
import DotsHorizontal from "vue-material-design-icons/DotsHorizontal.vue";
</script>

<template>
    <section
        id="OverlaySection"
        class="fixed z-40 top-0 left-0 w-full h-screen bg-black bg-opacity-60 p-3 overflow-auto flex items-center justify-center flex-wrap"
        @click="emit('closeOverlay')"
    >
        <button class="absolute right-3 top-3 z-50 basis-full">
            <Close :size="36" fillColor="#FFFFFF"></Close>
        </button>

        <div
            class="flex items-center justify-center flex-wrap my-50 z-50"
            @click.stop
        >
            <article
                class="md:max-w-6xl sm:max-w-[92%] max-w-full md:max-h-[calc(100%-100px)] max-h-full bg-white rounded-xl m-auto"
            >
                <div
                    class="w-full h-full md:flex rounded-xl overflow-auto m-auto"
                >
                    <!-- Image -->
                    <div class="flex items-center w-full">
                        <img
                            class="max-w-[720] max-h-[720]"
                            src="https://picsum.photos/id/35/720/720"
                        />
                    </div>

                    <!-- Description + Comments -->
                    <div class="w-full relative md:max-w-[400px]">
                        <div
                            class="flex items-center justify-between p-3 border-b"
                        >
                            <div class="flex items-center">
                                <img
                                    src="https://picsum.photos/id/50/300/320"
                                    class="rounded-full w-[38px] h-[38px]"
                                />
                                <h3
                                    class="ml-4 font-extrabold sm:text-base text-sm"
                                >
                                    NAME HERE
                                </h3>
                                <p class="flex items-center text-gray-500">
                                    <span
                                        class="-mt-5 ml-2 mr-[5px] sm:text-4xl text-2xl"
                                        >.</span
                                    >
                                    DATE HERE
                                </p>
                            </div>
                            <button class="cursor-pointer">
                                <DotsHorizontal
                                    :size="27"
                                    @click.prevent="deleteType = true"
                                ></DotsHorizontal>
                            </button>
                        </div>
                        <div class="overflow-y-auto h-[calc(100%-170px)]">
                            <div class="flex items-center justify-between p-3">
                                <div class="flex items-center relative">
                                    <img
                                        src="https://picsum.photos/id/50/300/320"
                                        class="absolute rounded-full w-[38px] h-[38px] -top-1"
                                    />

                                    <p class="ml-14 mt-1">
                                        <span
                                            class="font-extrabold sm:text-base text-sm mr-2"
                                        >
                                            NAME HERE
                                        </span>
                                        <span
                                            class="text-gray-800 sm:text-base text-sm"
                                        >
                                            COMMENT HERE
                                        </span>
                                    </p>
                                </div>
                            </div>
                            <div class="p-3">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <img
                                            src="https://picsum.photos/id/50/300/320"
                                            class="rounded-full w-[38px] h-[38px]"
                                        />
                                        <p
                                            class="ml-4 font-extrabold sm:text-base text-sm"
                                        >
                                            NAME HERE
                                            <span
                                                class="font-light text-gray-700 sm:text-sm text-xs"
                                                >COMMENT TIME</span
                                            >
                                        </p>
                                    </div>
                                    <button class="cursor-pointer">
                                        <DotsHorizontal
                                            :size="27"
                                        ></DotsHorizontal>
                                    </button>
                                </div>
                                <p class="sm:text-sm text-xs pl-14">COMMENT</p>
                            </div>
                            <div class="md:hidden pb-16"></div>
                        </div>

                        <LikeSection class="px-5 border-t mb-2"></LikeSection>

                        <!-- Add Comment-->
                        <div
                            class="absolute flex border bottom-0 w-full max-h-[230px] bg-white overflow-auto"
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
        @closeSettingPost="deleteType = false"
    ></SettingPostOverlay>
</template>
