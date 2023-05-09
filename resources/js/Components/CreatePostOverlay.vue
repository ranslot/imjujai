<script setup>
import { ref, reactive } from "vue";
import { router, usePage } from "@inertiajs/vue3";

// const user = usePage().props.auth.user;

// Define an emit function for emitting a "close" event to the parent component
const emit = defineEmits(["close"]);

// Define reactive data for the form inputs, object for displaying error messages, references for the validity of the file input, the file display URL, and the textarea element
const form = reactive({
    text: null,
    file: null,
});
let isValidFile = ref(null);
let fileDisplay = ref("");
let textarea = ref("");
let error = ref({
    text: null,
    file: null,
});

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

    // Scroll to the textarea section
    setTimeout(() => {
        document
            .getElementById("TextAreaSection")
            .scrollIntoView({ behavior: "smooth" });
    }, 300);
}

function CreatePost() {
    // Reset error messages
    error.value.text = null;
    error.value.file = null;

    // Send a POST request to the /posts endpoint with the form data
    router.post("/posts", form, {
        forceFormData: true,
        preserveScroll: true,
        // If there are any errors returned from the server, display them in the error object
        onError: (errors) => {
            errors && errors.text ? (error.value.text = errors.text) : "";
            errors && errors.file ? (error.value.file = errors.file) : "";
        },
        // If the request is successful, call the closeOverlay function to reset the form and close the overlay
        onSuccess: () => {
            closeOverlay();
        },
    });
}

function closeOverlay() {
    // Reset the form data and clear the file display URL
    form.text = null;
    form.file = null;
    fileDisplay.value = "";

    // Emit a "close" event to notify the parent component that the overlay should be closed
    emit("close");
}

//icon
import Close from "vue-material-design-icons/Close.vue";
import ArrowLeft from "vue-material-design-icons/ArrowLeft.vue";
import MapMarkerOutline from "vue-material-design-icons/MapMarkerOutline.vue";
import ChevronDown from "vue-material-design-icons/ChevronDown.vue";
</script>

<template>
    <section
        id="OverlaySection"
        class="fixed bg-black bg-opacity-60 p-3 z-50 top-0 left-0 h-screen w-full"
        @click="closeOverlay"
    >
        <button class="absolute cursor-pointer top-0 right-3 p-3">
            <Close fillColor="#FFFFFF" :size="27"></Close>
        </button>

        <article
            class="max-w-5xl h-[calc(100%-100px)] mx-auto mt-10 bg-white rounded-xl"
            @click.stop
        >
            <div
                class="flex items-center justify-between w-full p-3 border-b border-gray-300"
            >
                <ArrowLeft
                    fillColor="#000000"
                    :size="30"
                    @click="closeOverlay"
                    class="cursor-pointer"
                ></ArrowLeft>
                <h2 class="text-lg font-extrabold">Create new post</h2>
                <button
                    class="text-lg text-blue-500 hover:text-gray-800 font-extrabold"
                    @click="CreatePost"
                >
                    Share
                </button>
            </div>
            <div
                class="w-full md:flex h-[calc(100%-55px)] rounded-xl overflow-auto"
            >
                <div
                    class="flex items-center justify-center bg-gray-100 w-full h-full overflow-hidden"
                >
                    <div
                        class="flex flex-col items-center mx-auto"
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
                    <img
                        v-if="fileDisplay && isValidFile === true"
                        class="min-w-[400px] p-4 mx-auto"
                        :src="fileDisplay"
                    />
                </div>
                <div id="TextAreaSection" class="max-w-[720px] w-full relative">
                    <div class="flex items-center justify-between p-3">
                        <div class="flex items-center">
                            <img
                                class="rounded-full w-[38px] h-[38px]"
                                src="https://picsum.photos/id/50/300/320"
                                alt=""
                            />
                            <h3 class="ml-4 font-extrabold text-[16px]">
                                NAME HERE
                            </h3>
                        </div>
                    </div>
                    <h3
                        v-if="error && error.text"
                        class="text-red-500 text-center p-2 font-extrabold text-lg"
                    >
                        {{ error.text }}
                    </h3>
                    <div class="flex w-full max-h-[200px] bg-white border-b">
                        <textarea
                            v-model="form.text"
                            ref="textarea"
                            rows="10"
                            placeholder="Caption..."
                            class="placeholder-gray-400 w-full border-0 my-2 z-50 focus:ring-0 text-gray-600 text-[18px] max-h-full resize-none"
                        ></textarea>
                    </div>

                    <div class="flex items-center justify-between border-b p-3">
                        <h3 class="text-lg font-extrabold text-gray-500">
                            Add Location
                        </h3>
                        <MapMarkerOutline :size="27"></MapMarkerOutline>
                    </div>
                    <div class="flex items-center justify-between border-b p-3">
                        <h3 class="text-lg font-extrabold text-gray-500">
                            Accessability
                        </h3>
                        <ChevronDown :size="27"></ChevronDown>
                    </div>
                    <div class="flex items-center justify-between border-b p-3">
                        <h3 class="text-lg font-extrabold text-gray-500">
                            Advance Setting
                        </h3>
                        <ChevronDown :size="27"></ChevronDown>
                    </div>
                </div>
            </div>
        </article>
    </section>
</template>
