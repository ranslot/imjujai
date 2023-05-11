<script setup>
import { computed, toRefs } from "vue";
import { usePage } from "@inertiajs/vue3";

const user = usePage().props.auth.user;

const props = defineProps({ post: Object, userLikes: Object });
const { post, userLikes } = toRefs(props);

const emit = defineEmits(["like"]);

const isLiked = computed(() => {
    for (let i = 0; i < userLikes.value.length; i++) {
        if (post.value.id === userLikes.value[i].post_id) {
            return true;
        }
    }
    return false;
});

//icon
import HeartOutline from "vue-material-design-icons/HeartOutline.vue";
import Heart from "vue-material-design-icons/Heart.vue";
import SendOutline from "vue-material-design-icons/SendOutline.vue";
import CommentOutline from "vue-material-design-icons/CommentOutline.vue";
import BookmarkOutline from "vue-material-design-icons/BookmarkOutline.vue";
</script>

<template>
    <section class="flex z-20 items-center justify-between">
        <div class="flex first-line:items-center">
            <button class="-mt-[14px]" @click="$emit('like', { post, user })">
                <Heart
                    v-if="isLiked"
                    class="pl-3 cursor-pointer"
                    :size="30"
                ></Heart>
                <HeartOutline
                    v-else
                    class="pl-3 cursor-pointer"
                    :size="30"
                ></HeartOutline>
            </button>
            <CommentOutline class="pl-3 pt-[10px]" :size="30"></CommentOutline>
            <SendOutline class="pl-3 pt-[10px]" :size="30"></SendOutline>
        </div>
        <BookmarkOutline class="pl-3 pt-[10px]" :size="30"></BookmarkOutline>
    </section>
</template>
