<script setup>
import { ref, toRefs } from "vue";
import { usePage, useForm, router } from "@inertiajs/vue3";

import "@/style/animation.css";
import FadedBackgroundLayout from "@/Layouts/FadedBackgroundLayout.vue";
import LoadingOverlay from "@/Components/LoadingOverlay.vue";

const props = defineProps({ post: Object });
const { post } = toRefs(props);
const user = usePage().props.auth.user;

const editForm = useForm({
    text: post.value.text,
    tags: post.value.tags,
    eatOrCook: post.value.eat_or_cook,
});
let textarea = ref("");
let error = ref({
    text: null,
});

let editPostProgress = ref(false);

const emit = defineEmits(["closeEditPost", "editSelected"]);

async function EditPost() {
    error.value.text = null;

    router.put(`/posts/${post.value.id}`, editForm, {
        onError: (errors) => {
            editUserProgress.value = false;
            errors && errors.text ? (error.value.text = errors.text) : "";
        },
        onSuccess: () => {
            editPostProgress.value = false;
            editForm.text = null;
            editForm.tags = null;
            emit("closeEditPost");
            emit("editSelected");
        },
        onProgress: () => {
            editPostProgress.value = true;
        },
    });
}

//icon
import Close from "vue-material-design-icons/Close.vue";
import ArrowLeft from "vue-material-design-icons/ArrowLeft.vue";
import TagMultiple from "vue-material-design-icons/TagMultiple.vue";
</script>
<template>
    <FadedBackgroundLayout>
        <button
            class="fixed right-2 top-2 z-50 basis-full bg-white bg-opacity-25 rounded-xl cursor-pointer"
        >
            <Close
                :size="36"
                fillColor="#000000"
                @click="emit('closeEditPost')"
            ></Close>
        </button>
        <article
            class="bg-white rounded-xl top-5 mt-5 transform-gpu transition scale-in"
        >
            <div
                class="sticky flex items-center justify-between w-full p-1 border-b border-gray-300"
            >
                <ArrowLeft
                    fillColor="#000000"
                    :size="30"
                    @click="emit('closeEditPost')"
                    class="cursor-pointer px-2"
                ></ArrowLeft>
                <h2 class="text-lg font-extrabold">แก้ไขโพสต์</h2>
                <button
                    class="text-lg text-white font-extrabold rounded-xl bg-blue-600 hover:bg-blue-500 px-3 py-2"
                    @click="EditPost"
                >
                    แก้ไข
                </button>
            </div>
            <div
                class="w-full flex flex-col md:flex-row h-fit"
                v-if="user.id === post.user.id"
            >
                <div
                    id="TextAreaSection"
                    class="max-w-[720px] w-full h-full relative flex flex-col gap-3 justify-between"
                >
                    <ul
                        class="flex flex-row items-center gap-5 px-3 pt-4 border-t"
                    >
                        <li class="font-extrabold text-md text-gray-700">
                            แก้ไขรายละเอียดภาพ :
                        </li>
                        <li class="">
                            <input
                                id="ate"
                                type="radio"
                                v-model="editForm.eatOrCook"
                                value="0"
                                class="hidden peer"
                                :checked="post.eat_or_cook === 0"
                            />
                            <label
                                for="ate"
                                class="bg-gray-300 hover:bg-gray-300 font-extrabold border-2 border-gray-300 focus:ring-blue-500 p-2 rounded-2xl peer-checked:text-blue-500 peer-checked:border-blue-500 cursor-pointer"
                                >ได้กิน</label
                            >
                        </li>
                        <li class="">
                            <input
                                id="cooked"
                                type="radio"
                                v-model="editForm.eatOrCook"
                                value="1"
                                class="hidden peer"
                                :checked="post.eat_or_cook === 1"
                            />
                            <label
                                for="cooked"
                                class="bg-gray-300 hover:bg-gray-300 font-extrabold border-2 border-gray-300 focus:ring-blue-500 p-2 rounded-2xl peer-checked:text-blue-500 peer-checked:border-blue-500 cursor-pointer"
                                >ได้ทำ</label
                            >
                        </li>
                    </ul>
                    <h3
                        v-if="error && error.text"
                        class="text-red-500 text-center p-2 font-extrabold text-lg"
                    >
                        {{ error.text }}
                    </h3>
                    <div class="flex w-full max-h-[200px]">
                        <textarea
                            v-model="editForm.text"
                            ref="textarea"
                            rows="10"
                            placeholder="Caption..."
                            class="placeholder-gray-400 w-full border-0 my-2 z-50 focus:ring-0 text-gray-600 text-[18px] max-h-full resize-none"
                        ></textarea>
                    </div>

                    <div class="flex flex-col justify-between border-t p-3">
                        <div class="flex items-center justify-between">
                            <div
                                class="flex items-center justify-between gap-7"
                            >
                                <h3
                                    class="text-lg font-extrabold text-gray-700"
                                >
                                    แก้ไขแท็ก
                                </h3>
                                <p class="text-gray-400 text-sm mt-[3px]">
                                    ใช้ "," เพื่อแยกแท็ก
                                </p>
                            </div>

                            <TagMultiple :size="27"></TagMultiple>
                        </div>

                        <input
                            type="text"
                            v-model="editForm.tags"
                            id="tags"
                            placeholder="Tags..."
                            class="placeholder-gray-400 border-0 focus:ring-0 w-full text-gray-600 resize-none"
                        />
                    </div>
                </div>
            </div>
            <div
                v-else
                class="w-full flex flex-col md:flex-row h-fit items-center justify-center"
            >
                <div
                    class="text-red-500 font-extrabold text-lg text-center p-3"
                >
                    Unautherized session
                </div>
            </div>
        </article>
    </FadedBackgroundLayout>
    <LoadingOverlay v-if="editPostProgress"></LoadingOverlay>
</template>
