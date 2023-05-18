<script setup>
import { ref } from "vue";
import { router, usePage, useForm } from "@inertiajs/vue3";

import "@/style/scaleIn.css";

import "vue-advanced-cropper/dist/style.css";
import { Cropper } from "vue-advanced-cropper";
import LoadingOverlay from "@/Components/LoadingOverlay.vue";

const user = usePage().props.auth.user;

// Define an emit function for emitting a "close" event to the parent component
const emit = defineEmits(["close"]);

// Define reactive data for the form inputs, object for displaying error messages, references for the validity of the file input, the file display URL, and the textarea element
const form = useForm({
    text: null,
    file: null,
    tags: null,
    eatOrCook: 0,
    height: 0,
    width: 0,
    left: 0,
    top: 0,
});
let isValidFile = ref(null);
let fileDisplay = ref("");
let textarea = ref("");
let error = ref({
    text: null,
    file: null,
});

let createPostProgress = ref(false);

const cropper = ref(null);

function getUploadImage(e) {
    form.file = e.target.files[0];
    let fileExtention = form.file.name.substring(
        form.file.name.lastIndexOf(".") + 1
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

async function CreatePost() {
    // Reset error messages
    error.value.text = null;
    error.value.file = null;

    // Send a POST request to the /posts endpoint with the form data
    router.post("/posts", form, {
        forceFormData: true,
        preserveScroll: true,
        // If there are any errors returned from the server, display them in the error object
        onError: (errors) => {
            editUserProgress.value = false;
            errors && errors.text ? (error.value.text = errors.text) : "";
            errors && errors.file ? (error.value.file = errors.file) : "";

            if (errors.text && !errors.file) {
                setTimeout(() => {
                    document
                        .getElementById("TextAreaSection")
                        .scrollIntoView({ behavior: "smooth" });
                }, 300);
            }
        },
        // If the request is successful, call the closeOverlay function to reset the form and close the overlay
        onSuccess: () => {
            createPostProgress.value = false;
            closeOverlay();
        },
        onProgress: () => {
            createPostProgress.value = true;
        },
    });
}

function CancleImage() {
    form.file = null;
    form.height = 0;
    form.width = 0;
    form.left = 0;
    form.top = 0;
    fileDisplay.value = "";
}

function closeOverlay() {
    // Reset the form data and clear the file display URL
    form.reset();
    fileDisplay.value = "";

    // Emit a "close" event to notify the parent component that the overlay should be closed
    emit("close");
}

function change({ coordinates }) {
    form.height = coordinates.height | 0;
    form.width = coordinates.width | 0;
    form.left = coordinates.left | 0;
    form.top = coordinates.top | 0;
}

function zoomIn() {
    cropper.value.zoom(1.25);
}
function zoomOut() {
    cropper.value.zoom(0.75);
}

//icon
import Close from "vue-material-design-icons/Close.vue";
import ArrowLeft from "vue-material-design-icons/ArrowLeft.vue";
import TagMultiple from "vue-material-design-icons/TagMultiple.vue";
import MagnifyPlusOutline from "vue-material-design-icons/MagnifyPlusOutline.vue";
import MagnifyMinusOutline from "vue-material-design-icons/MagnifyMinusOutline.vue";
</script>

<template>
    <section
        id="OverlaySection"
        class="fixed flex flex-col items-center md:justify-center top-0 flex-wrap bg-black bg-opacity-60 p-3 z-50 left-0 h-screen w-full overflow-auto"
    >
        <button
            class="fixed right-2 top-2 z-50 basis-full bg-white bg-opacity-25 rounded-xl"
        >
            <Close :size="30" fillColor="#000000" @click="closeOverlay"></Close>
        </button>

        <article
            class="w-full max-w-6xl h-fit bg-white rounded-xl top-5 mt-5 transform-gpu transition scale-in"
        >
            <div
                class="sticky flex items-center justify-between w-full p-1 border-b border-gray-300"
            >
                <ArrowLeft
                    fillColor="#000000"
                    :size="30"
                    @click="closeOverlay"
                    class="cursor-pointer px-2"
                ></ArrowLeft>
                <h2 class="text-lg font-extrabold">Create new post</h2>
                <button
                    class="text-lg text-white font-extrabold rounded-xl bg-blue-600 hover:bg-blue-500 px-3 py-2"
                    @click="CreatePost"
                >
                    Post
                </button>
            </div>
            <div class="w-full flex flex-col md:flex-row h-fit">
                <div
                    class="flex flex-col items-center justify-center w-full overflow-hidden relative"
                >
                    <div
                        v-if="fileDisplay && isValidFile === true"
                        class="flex items-center gap-10 mt-8 absolute top-2 z-10 bg-white bg-opacity-40 rounded-xl"
                    >
                        <MagnifyPlusOutline
                            title="Zoom In"
                            fillColor="#000000"
                            :size="36"
                            class="cursor-pointer"
                            @click="zoomIn"
                        ></MagnifyPlusOutline>
                        <MagnifyMinusOutline
                            title="Zoom Out"
                            fillColor="#000000"
                            :size="36"
                            class="cursor-pointer"
                            @click="zoomOut"
                        ></MagnifyMinusOutline>
                    </div>

                    <div
                        class="flex flex-col items-center justify-center mx-auto md:h-fit h-[300px]"
                        v-if="!fileDisplay"
                    >
                        <label
                            for="file"
                            class="bg-blue-400 hover:bg-blue-300 rounded-lg p-2.5 text-white font-extrabold"
                        >
                            Upload Photo
                        </label>
                        <input
                            id="file"
                            type="file"
                            class="hidden"
                            @input="getUploadImage"
                        />

                        <h3
                            v-if="error && error.file"
                            class="text-red-500 text-center p-2 font-extrabold text-lg"
                        >
                            {{ error.file }}
                        </h3>
                        <h3
                            v-if="!fileDisplay && isValidFile === false"
                            class="text-red-500 text-center p-2 font-extrabold text-lg"
                        >
                            Upload failed
                        </h3>
                    </div>
                    <div
                        v-if="fileDisplay && isValidFile === true"
                        class="text-center max-h-full max-w-full flex flex-col items-center justify-between"
                    >
                        <div class="flex flex-col items-center">
                            <h2 class="font-extrabold text-lg py-1">
                                Crop Photo
                            </h2>
                            <div class="h-[500px] w-full">
                                <Cropper
                                    class="w-full h-full"
                                    ref="cropper"
                                    :src="fileDisplay"
                                    @change="change"
                                    :stencil-props="{
                                        handlers: {},
                                        movable: false,
                                        resizable: false,
                                    }"
                                    :stencil-size="{
                                        width: 900,
                                        height: 900,
                                    }"
                                    :resize-image="{
                                        wheel: false,
                                    }"
                                    image-restriction="stencil"
                                    backgroundClass="my-background"
                                />
                            </div>
                        </div>
                        <button
                            class="text-white p-2 my-2 font-extrabold text-lg rounded-xl bg-gray-400 hover:bg-gray-500 bottom-0 z-20"
                            @click="CancleImage"
                        >
                            Change Photo
                        </button>
                    </div>
                </div>
                <div
                    id="TextAreaSection"
                    class="max-w-[720px] w-full h-full relative flex flex-col gap-3 justify-between"
                >
                    <div class="flex items-center justify-between p-3">
                        <div class="flex items-center">
                            <img
                                class="rounded-full w-[38px] h-[38px]"
                                width="38"
                                height="38"
                                :src="user.file"
                                :alt="user.name"
                            />
                            <h3 class="ml-4 font-extrabold text-[16px]">
                                {{ user.name }}
                            </h3>
                        </div>
                    </div>
                    <ul
                        class="flex flex-row items-center gap-5 px-3 pt-4 border-t"
                    >
                        <li class="font-extrabold text-md text-gray-500">
                            What did you do on this photo :
                        </li>
                        <li class="">
                            <input
                                id="ate"
                                type="radio"
                                v-model="form.eatOrCook"
                                value="0"
                                checked="checked"
                                class="hidden peer"
                            />
                            <label
                                for="ate"
                                class="bg-gray-200 hover:bg-gray-300 font-extrabold border-2 border-gray-200 focus:ring-blue-500 p-2 rounded-2xl peer-checked:text-blue-500 peer-checked:border-blue-500 cursor-pointer"
                                >I Ate</label
                            >
                        </li>
                        <li class="">
                            <input
                                id="cooked"
                                type="radio"
                                v-model="form.eatOrCook"
                                value="1"
                                class="hidden peer"
                            />
                            <label
                                for="cooked"
                                class="bg-gray-200 hover:bg-gray-300 font-extrabold border-2 border-gray-200 focus:ring-blue-500 p-2 rounded-2xl peer-checked:text-blue-500 peer-checked:border-blue-500 cursor-pointer"
                                >I Cooked</label
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
                            v-model="form.text"
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
                                    class="text-lg font-extrabold text-gray-500"
                                >
                                    Add tags
                                </h3>
                                <p class="text-gray-400 text-sm mt-[3px]">
                                    Use "," to separate tags
                                </p>
                            </div>

                            <TagMultiple :size="27"></TagMultiple>
                        </div>

                        <input
                            type="text"
                            v-model="form.tags"
                            id="tags"
                            placeholder="Tags..."
                            class="placeholder-gray-400 border-0 focus:ring-0 w-full text-gray-600 resize-none"
                        />
                    </div>
                </div>
            </div>
        </article>
    </section>
    <LoadingOverlay v-if="createPostProgress"> </LoadingOverlay>
</template>

<style>
.my-background {
    background-color: rgba(0, 0, 0, 0);
}
</style>
