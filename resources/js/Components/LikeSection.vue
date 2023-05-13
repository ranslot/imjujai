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
import FoodAppleOutline from "vue-material-design-icons/FoodAppleOutline.vue";
import FoodApple from "vue-material-design-icons/FoodApple.vue";
import CommentOutline from "vue-material-design-icons/CommentOutline.vue";
import BookmarkOutline from "vue-material-design-icons/BookmarkOutline.vue";
</script>

<template>
    <section class="flex z-20 items-center justify-between">
        <div class="flex first-line:items-center">
            <button class="-mt-[20px]" @click="$emit('like', { post, user })">
                <FoodApple
                    v-if="isLiked"
                    class="pl-3 cursor-pointer"
                    :size="30"
                ></FoodApple>
                <FoodAppleOutline
                    v-else
                    class="pl-3 cursor-pointer"
                    :size="30"
                ></FoodAppleOutline>
            </button>
            <CommentOutline class="pl-3 pt-[10px]" :size="27"></CommentOutline>
        </div>
        <BookmarkOutline class="pl-3 pt-[10px]" :size="30"></BookmarkOutline>
    </section>
</template>
