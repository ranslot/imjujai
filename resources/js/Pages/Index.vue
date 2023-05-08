<script setup>
import { Head, Link } from "@inertiajs/vue3";
import { ref, toRefs } from "vue";
import MainLayout from "@/Layouts/MainLayout.vue";
import LikeSection from "@/Components/LikeSection.vue";
import ShowPostOverlay from "@/Components/ShowPostOverlay.vue";

let currentPost = ref(null);
let openOverlay = ref(false);

const props = defineProps({ post: Object, allUsers: Object });
const { post, allUsers } = toRefs(props);

//icon
import DotsHorizontal from "vue-material-design-icons/DotsHorizontal.vue";
</script>

<template>
    <Head title="Home"></Head>
    <MainLayout>
        <section
            id="Posts"
            class="max-w-[570px] mx-auto pb-3 bg-white rounded-xl"
        >
            <article class="flex items-center justify-between py-2 px-4">
                <div class="flex items-center">
                    <Link href="/" class="flex items-center">
                        <img
                            src="https://picsum.photos/id/50/300/320"
                            class="rounded-full w-[38px] h-[38px]"
                        />
                        <h3 class="ml-4 font-extrabold text-sm sm:text-base">
                            NAME HERE
                        </h3>
                    </Link>
                    <p
                        class="flex items-center pl-2 text-gray-500 text-sm sm:text-base"
                    >
                        DATE HERE
                    </p>
                </div>
                <DotsHorizontal
                    class="cursor-pointer"
                    :size="27"
                ></DotsHorizontal>
            </article>
            <article
                class="rounded w-full h-fit flex items-center overflow-hidden cursor-pointer"
                @click="openOverlay = true"
            >
                <img
                    class="mx-auto w-full h-fit object-scale-down"
                    src="https://picsum.photos/id/45/800/800"
                />
            </article>
            <article class="px-4">
                <LikeSection></LikeSection>
                <h4 class="text-black font-extrabold text-sm py-1.5">
                    10 likes
                </h4>
                <p class="text-sm">
                    <span class="text-black font-extrabold">NAME NUMBER</span>
                    CAPTION
                </p>
                <button
                    class="text-gray-400 font-extrabold py-1.5"
                    @click="openOverlay = true"
                >
                    View all comments
                </button>
            </article>
        </section>
    </MainLayout>
    <ShowPostOverlay
        v-if="openOverlay"
        :post="currentPost"
        @closeOverlay="openOverlay = false"
    ></ShowPostOverlay>
</template>

<style>
body {
    background-color: rgba(243, 244, 246, 1);
}
</style>
