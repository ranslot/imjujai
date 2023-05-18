<script setup>
import { toRefs } from "vue";
import "@/style/animation.css";

import FadedBackgroundLayout from "@/Layouts/FadedBackgroundLayout.vue";

const emit = defineEmits(["closeSettingPost", "deleteSelected", "editShow"]);

const props = defineProps({ deleteType: String, id: Number });
const { deleteType, id } = toRefs(props);

//icon
import Close from "vue-material-design-icons/Close.vue";
</script>

<template>
    <FadedBackgroundLayout @click="emit('closeSettingPost')">
        <button
            class="absolute right-3 top-3 z-50 basis-full bg-white bg-opacity-25 rounded-xl cursor-pointer"
        >
            <Close :size="36" fillColor="#000000"></Close>
        </button>
        <div
            class="text-center max-w-sm w-full h-fit mx-auto mt-10 bg-white rounded-xl transform-gpu transition scale-in"
            id="SettingPostOverlay"
            @click.stop
        >
            <button
                class="font-extrabold w-full p-3 text-red-700 text-lg border-b border-gray-300 cursor-pointer"
                @click="emit('deleteSelected', { deleteType, id })"
            >
                Delete {{ deleteType }}
            </button>
            <button
                v-if="deleteType === 'Post'"
                class="font-extrabold w-full p-3 text-lg border-b border-gray-300 cursor-pointer"
                @click="emit('editShow')"
            >
                Edit Post
            </button>
            <button
                class="p-3 text-lg cursor-pointer w-full"
                @click="emit('closeSettingPost')"
            >
                Cancle
            </button>
        </div>
    </FadedBackgroundLayout>
</template>
