<script setup>
import { ref, toRefs } from "vue";

defineEmits(["selectPost"]);
const props = defineProps(["postByUser"]);
const { postByUser } = toRefs(props);
let isHover = ref(false);

//icon
import Heart from "vue-material-design-icons/Heart.vue";
import Comment from "vue-material-design-icons/Comment.vue";
</script>

<template>
    <article
        @mouseenter="isHover = true"
        @mouseleave="isHover = false"
        class="flex items-center justify-center relative cursor-pointer"
    >
        <div
            v-if="isHover"
            :class="isHover ? 'bg-black bg-opacity-40' : ''"
            class="absolute w-full h-full z-50 flex items-center justify-around text-lg font-extrabold text-white"
        >
            <div class="flex items-center justify-around w-[50%]">
                <div class="flex items-center justify-center">
                    <Heart :size="30" fillColor="#FFFFFF"></Heart>
                    <div class="pl-1">5</div>
                </div>
                <div class="flex items-center justify-center">
                    <Comment :size="30" fillColor="#FFFFFF"></Comment>
                    <div class="pl-1">10</div>
                </div>
            </div>
        </div>
        <img
            class="aspect-square mx-auto z-0 object-cover cursor-pointer"
            src="https://picsum.photos/id/8/800/800"
        />
    </article>
</template>
