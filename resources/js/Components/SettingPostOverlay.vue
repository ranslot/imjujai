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
                class="font-extrabold w-full p-3 text-red-700 text-lg border-b border-gray-300 hover:bg-red-300 cursor-pointer rounded-t-xl"
                @click="emit('deleteSelected', { deleteType, id })"
            >
                ลบ{{ deleteType }}
            </button>
            <button
                v-if="deleteType === 'โพสต์'"
                class="font-extrabold w-full p-3 text-lg border-b border-gray-300 hover:bg-gray-300 cursor-pointer"
                @click="emit('editShow')"
            >
                แก้ไขโพสต์
            </button>
            <button
                class="p-3 text-lg cursor-pointer hover:bg-gray-300 w-full rounded-b-xl"
                @click="emit('closeSettingPost')"
            >
                ยกเลิก
            </button>
        </div>
    </FadedBackgroundLayout>
</template>
