<script setup>
import { Link } from "@inertiajs/vue3";
import "@/style/animation.css";

import FadedBackgroundLayout from "@/Layouts/FadedBackgroundLayout.vue";

const emit = defineEmits(["closeSettingMenu"]);

//icon
import Close from "vue-material-design-icons/Close.vue";
</script>

<template>
    <FadedBackgroundLayout @click="emit('closeSettingMenu')">
        <button
            class="absolute right-3 top-3 z-50 basis-full bg-white bg-opacity-25 rounded-xl cursor-pointer"
        >
            <Close :size="36" fillColor="#000000"></Close>
        </button>
        <div
            id="SettingMenuOverlay"
            class="text-center max-w-sm w-full h-fit mx-auto mt-10 bg-white rounded-xl transform-gpu transition scale-in"
            @click.stop
        >
            <Link
                :href="route('logout')"
                as="button"
                method="post"
                class="font-extrabold w-full p-3 text-red-700 text-lg border-b border-gray-300 cursor-pointer"
                >Log out
            </Link>
            <button
                class="p-3 text-lg cursor-pointer w-full"
                @click="emit('closeSettingMenu')"
            >
                Cancle
            </button>
        </div>
    </FadedBackgroundLayout>
</template>
