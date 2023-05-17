<script setup>
import { toRefs } from "vue";

const props = defineProps({ comment: Object, user: Object });
const { comment, user } = toRefs(props);

defineEmits(["deleteComment"]);

import DotsHorizontal from "vue-material-design-icons/DotsHorizontal.vue";
</script>
<template>
    <div class="flex flex-col justify-between md:w-[300px] lg:w-full">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <img
                    :src="comment.user.file"
                    class="rounded-full w-[38px] h-[38px]"
                    width="38"
                    height="38"
                    :alt="comment.user.name"
                />
                <p class="ml-4 font-extrabold sm:text-base text-sm">
                    {{ comment.user.name }}
                </p>
            </div>

            <div class="flex gap-2 items-center">
                <span
                    class="font-light text-gray-400 sm:text-sm text-xs truncate"
                >
                    {{ comment.created_at }}
                </span>
                <button
                    v-if="user.id === comment.user.id"
                    @click.prevent="
                        $emit('deleteComment', 'Comment', comment.id)
                    "
                    class="cursor-pointer -top-7"
                >
                    <DotsHorizontal :size="27" class=""></DotsHorizontal>
                </button>
            </div>
        </div>
        <p class="sm:text-sm text-xs px-5">{{ comment.text }}</p>
    </div>
</template>
