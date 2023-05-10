<script setup>
import { toRefs } from "vue";

const props = defineProps({ comment: Object, user: Object });
const { comment, user } = toRefs(props);

defineEmits(["deleteComment"]);

import DotsHorizontal from "vue-material-design-icons/DotsHorizontal.vue";
</script>
<template>
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <img
                :src="comment.user.file"
                class="rounded-full w-[38px] h-[38px]"
            />
            <p class="ml-4 font-extrabold sm:text-base text-sm">
                {{ comment.user.name }}
                <span class="font-light text-gray-700 sm:text-sm text-xs">
                    {{ comment.created_at }}
                </span>
            </p>
        </div>
        <button
            v-if="user.id === comment.user.id"
            @click.prevent="$emit('deleteComment', 'Comment', comment.id)"
            class="cursor-pointer"
        >
            <DotsHorizontal :size="27"></DotsHorizontal>
        </button>
    </div>
    <p class="sm:text-sm text-xs pl-14">{{ comment.text }}</p>
</template>
