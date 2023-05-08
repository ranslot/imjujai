<script setup>
import { usePage } from "@inertiajs/vue3";
// const user = usePage().props.auth.user;

import { toRefs } from "vue";
const props = defineProps({ iconString: String });
const { iconString } = toRefs(props);

//icon
import HomeOutline from "vue-material-design-icons/HomeOutline.vue";
import BellOutline from "vue-material-design-icons/BellOutline.vue";
import CogOutline from "vue-material-design-icons/CogOutline.vue";
import Plus from "vue-material-design-icons/Plus.vue";
let icon = null;
if (iconString.value === "Home") icon = HomeOutline;
if (iconString.value === "Setting") icon = CogOutline;
if (iconString.value === "Notification") icon = BellOutline;
if (iconString.value === "Create") icon = Plus;
</script>

<template>
    <div class="w-full">
        <div
            class="flex items-center px-5 py-2 rounded-2xl hover:bg-gray-100 cursor-pointer"
            :class="
                iconString === 'Setting'
                    ? 'hover:bg-gray-400 flex-1 rounded-full bg-gray-200 justify-center gap-2 '
                    : ''
            "
        >
            <div v-if="iconString === 'Profile'" class="mr-1">
                <img
                    class="rounded-full ml-[2px] w-[34px] border-[2px] border-black"
                    src="https://picsum.photos/id/50/300/320"
                />
            </div>
            <component
                v-else
                :is="icon"
                fillColor="#000000"
                :size="36"
                class="pr-[1px]"
            ></component>
            <span class="text-[18px] font-bold text-black pl-3 pt-1">
                {{ iconString }}
            </span>
        </div>
    </div>
</template>
