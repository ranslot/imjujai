<script setup>
import { toRefs } from "vue";
import { usePage } from "@inertiajs/vue3";

const props = defineProps({ xdd: String });
const { xdd } = toRefs(props);
// const user = usePage().props.auth.user;
</script>

<template>
    <div class="w-full">
        <div class="flex items-center">
            <span class="text-[36px] xl:block hidden">{{ xdd }}</span>
        </div>
    </div>
</template>
