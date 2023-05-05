<script setup>
import { usePage } from "@inertiajs/vue3";
// const user = usePage().props.auth.user;

import { toRefs } from "vue";
const props = defineProps({ iconString: String });
const { iconString } = toRefs(props);

import HomeOutline from "vue-material-design-icons/HomeOutline.vue";
import BellOutline from "vue-material-design-icons/BellOutline.vue";
import Magnify from "vue-material-design-icons/Magnify.vue";
import CogOutline from "vue-material-design-icons/CogOutline.vue";
let icon = null;
if (iconString.value === "Home") icon = HomeOutline;
if (iconString.value === "Logout") icon = CogOutline;
if (iconString.value === "Notification") icon = BellOutline;
if (iconString.value === "Search") icon = Magnify;
</script>

<template>
    <div class="w-full">
        <div class="flex items-center px-5 py-2 rounded-2xl hover:bg-gray-100">
            <div v-if="iconString === 'Profile'" class="mr-1">
                <img
                    class="rounded-full ml-[2px] w-[32px] cursor-pointer border-[2px] border-black"
                    src="https://picsum.photos/id/50/300/320"
                />
            </div>
            <component
                v-else
                :is="icon"
                fillColor="#000000"
                :size="34"
                class="pr-[1px]"
            ></component>
            <span class="text-[18px] font-bold text-black pl-3 pt-1">
                {{ iconString }}
            </span>
        </div>
    </div>
</template>
