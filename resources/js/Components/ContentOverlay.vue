<script setup>
import { ref, toRefs } from "vue";

defineEmits(["selectPost"]);
const props = defineProps(["post"]);
const { post } = toRefs(props);
let isHover = ref(false);

//icon
import Heart from "vue-material-design-icons/Heart.vue";
import Comment from "vue-material-design-icons/Comment.vue";
</script>

<template>
    <article
        @mouseenter="isHover = true"
        @click="isHover = false"
        @mouseleave="isHover = false"
        class="flex items-center justify-center relative cursor-pointer"
    >
        <div
            v-if="isHover"
            :class="isHover ? 'bg-black bg-opacity-40' : ''"
            class="absolute w-full h-full z-50 flex items-center justify-around text-lg font-extrabold text-white"
            @click="$emit('selectPost', post)"
        >
            <div class="flex items-center justify-around w-[50%]">
                <div class="flex items-center justify-center">
                    <Heart :size="30" fillColor="#FFFFFF"></Heart>
                    <div class="pl-1">{{ post.likes.length }}</div>
                </div>
                <div class="flex items-center justify-center">
                    <Comment :size="30" fillColor="#FFFFFF"></Comment>
                    <div class="pl-1">{{ post.comments.length }}</div>
                </div>
            </div>
        </div>
        <img
            class="aspect-square mx-auto z-0 object-cover cursor-pointer"
            width="312"
            height="312"
            :src="post.file"
            :alt="post.file"
            loading="lazy"
        />
    </article>
</template>
