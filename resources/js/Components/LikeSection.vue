<script setup>
import { computed, toRefs, watch, reactive } from "vue";
import { usePage, router } from "@inertiajs/vue3";

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

const state = reactive({
    likeStatus: isLiked.value,
});

watch(
    () => state.likeStatus,
    (likeStatus) => {
        if (likeStatus) {
            router.post(
                "/likes",
                {
                    post_id: post.value.id,
                },
                { preserveState: true }
            );
        } else {
            router.delete(`/likes/${user.id}/${post.value.id}`, {
                preserveState: true,
            });
        }
    }
);

//icon
import FoodAppleOutline from "vue-material-design-icons/FoodAppleOutline.vue";
import FoodApple from "vue-material-design-icons/FoodApple.vue";
import CommentOutline from "vue-material-design-icons/CommentOutline.vue";
</script>

<template>
    <section class="flex z-20 items-center justify-between">
        <div class="flex first-line:items-center">
            <button
                class="-mt-[20px]"
                @click="state.likeStatus = !state.likeStatus"
            >
                <FoodApple
                    v-if="state.likeStatus"
                    class="pl-3 cursor-pointer"
                    fillColor="#ff6961"
                    :size="30"
                ></FoodApple>
                <FoodAppleOutline
                    v-else
                    class="pl-3 cursor-pointer"
                    :size="30"
                ></FoodAppleOutline>
            </button>
            <CommentOutline
                class="pl-3 pt-[10px] cursor-pointer"
                :size="27"
                @click="$emit('clickComment')"
            ></CommentOutline>
        </div>
        <p
            class="flex items-center pl-2 text-gray-400 text-xs sm:text-sm pt-3 truncate"
        >
            โพสต์เมื่อ : {{ post.created_at }}
        </p>
    </section>
</template>
