<script setup>
import { ref, toRefs } from "vue";
import { usePage, useForm, router } from "@inertiajs/vue3";

import FadedBackgroundLayout from "@/Layouts/FadedBackgroundLayout.vue";
import "@/style/animation.css";
import LoadingOverlay from "@/Components/LoadingOverlay.vue";

const props = defineProps({ user: Object });
const { user } = toRefs(props);
const userAuth = usePage().props.auth.user;
const userForm = useForm({
    file: user.value.file,
    description: user.value.description,
});
let isValidFile = ref(null);
let fileDisplay = ref("");
let editUserProgress = ref(false);
let error = ref({
    text: null,
    file: null,
});

const emit = defineEmits(["closeEditUser"]);

function EditUser() {
    error.value.text = null;
    error.value.file = null;
    router.post(`/user/update/${userAuth.id}`, userForm, {
        forceFormData: true,
        onError: (errors) => {
            editUserProgress.value = false;
            errors && errors.file ? (error.value.file = errors.file) : "";
        },
        onSuccess: () => {
            editUserProgress.value = false;
            userForm.reset();
            emit("closeEditUser");
        },
        onProgress: () => {
            editUserProgress.value = true;
        },
    });
}

function getUploadUserImage(e) {
    userForm.file = e.target.files[0];
    let fileExtention = userForm.file.name.substring(
        userForm.file.name.lastIndexOf(".") + 1
    );

    // Check if the selected file has a valid extension (png, jpg, or jpeg)
    if (
        fileExtention === "png" ||
        fileExtention === "jpg" ||
        fileExtention === "jpeg"
    ) {
        isValidFile.value = true;
    } else {
        isValidFile.value = false;
        return;
    }

    // If the file is valid, create a URL for displaying the selected image
    fileDisplay.value = URL.createObjectURL(e.target.files[0]);
}
//icon
import Close from "vue-material-design-icons/Close.vue";
import ArrowLeft from "vue-material-design-icons/ArrowLeft.vue";
</script>

<template>
    <FadedBackgroundLayout>
        <button
            class="fixed right-2 top-2 z-50 basis-full bg-white bg-opacity-25 rounded-xl cursor-pointer"
        >
            <Close
                :size="36"
                fillColor="#000000"
                @click="emit('closeEditUser')"
            ></Close>
        </button>
        <article
            class="bg-white rounded-xl top-5 mt-5 max-w-[620px] w-[95%] transform-gpu transition scale-in"
        >
            <div
                class="sticky flex items-center justify-between w-full p-1 border-b border-gray-300"
            >
                <ArrowLeft
                    fillColor="#000000"
                    :size="30"
                    @click="emit('closeEditUser')"
                    class="cursor-pointer px-2"
                ></ArrowLeft>
                <h2 class="text-lg font-extrabold">แก้ไขผู้ใช้</h2>
                <button
                    class="text-lg text-white font-extrabold rounded-xl bg-blue-600 hover:bg-blue-500 px-3 py-2"
                    @click="EditUser"
                >
                    แก้ไข
                </button>
            </div>
            <div
                class="flex flex-col items-center justify-between gap-3"
                v-if="user.id === userAuth.id"
            >
                <div
                    class="flex flex-col items-center justify-between"
                    v-if="!fileDisplay"
                >
                    <h2 class="font-extrabold p-1 text-gray-400">
                        คลิกที่รูปเพื่อเปลี่ยนภาพผู้ใช้
                    </h2>
                    <label for="fileUser">
                        <img
                            :src="user.file"
                            :alt="user.name"
                            width="250"
                            height="250"
                            class="rounded-full hover:opacity-30 object-contain md:w-[260px] w-[150px] cursor-pointer m-5"
                            loading="lazy"
                        />
                    </label>
                    <input
                        v-if="user.id === $page.props.auth.user.id"
                        id="fileUser"
                        type="file"
                        class="hidden"
                        @input="getUploadUserImage"
                    />
                    <h3
                        v-if="!fileDisplay && isValidFile === false"
                        class="text-red-500 text-center p-2 font-extrabold text-lg"
                    >
                        ไฟล์ภาพไม่ถูกต้อง
                    </h3>
                </div>

                <div
                    class="flex flex-col items-center justify-between"
                    v-if="fileDisplay"
                >
                    <h2 class="font-extrabold p-1 text-gray-400">
                        คลิกที่รูปเพื่อเปลี่ยนภาพผู้ใช้
                    </h2>
                    <label
                        for="fileUser"
                        class="hover:opacity-30 object-contain md:w-[200px] w-[100px] cursor-pointer m-5 aspect-square"
                    >
                        <img
                            :src="fileDisplay"
                            :alt="user.name"
                            class="w-full h-full rounded-full"
                            loading="lazy"
                        />
                    </label>
                    <input
                        v-if="user.id === $page.props.auth.user.id"
                        id="fileUser"
                        type="file"
                        class="hidden"
                        @input="getUploadUserImage"
                    />
                    <h3
                        v-if="error && error.file"
                        class="text-red-500 text-center p-2 font-extrabold text-lg"
                    >
                        {{ error.file }}
                    </h3>
                </div>

                <div
                    id="TextAreaSection"
                    class="max-w-[720px] w-full h-full relative flex flex-col gap-3 justify-between border-t border-gray-300"
                >
                    <h3
                        v-if="error && error.text"
                        class="text-red-500 text-center p-2 font-extrabold text-lg"
                    >
                        {{ error.text }}
                    </h3>
                    <div class="flex flex-col w-full max-h-[200px]">
                        <h3 class="font-extrabold p-1 text-gray-400 m-3">
                            แก้ไขรายละเอียดผู้ใช้
                        </h3>
                        <textarea
                            v-model="userForm.description"
                            ref="textarea"
                            rows="10"
                            placeholder="เพิ่มรายละเอียดผู้ใช้..."
                            class="placeholder-gray-400 w-full border-0 my-2 z-50 focus:ring-0 text-gray-600 text-[18px] max-h-full resize-none"
                        >
                            {{ user.description }} 
                        </textarea>
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
    <LoadingOverlay v-if="editUserProgress"></LoadingOverlay>
</template>
