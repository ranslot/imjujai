<script setup>
import { Head, Link } from "@inertiajs/vue3";
import { ref, onMounted, toRefs } from "vue";
import MainLayout from "@/Layouts/MainLayout.vue";
import LikeSection from "@/Components/LikeSection.vue"

let windowWidth = ref(window.innerWidth);
let currentPost = ref(null);
let openOverlay = ref(false);

const props = defineProps({ post: Object, allUsers: Object });
const { post, allUsers } = toRefs(props);

onMounted(() => {
    window.addEventListener("resize", () => {
        windowWidth.value = window.innerWidth;
    });
});

//icon
import DotsHorizontal from "vue-material-design-icons/DotsHorizontal.vue";
</script>

<template>
    <Head title="Home" />
    <MainLayout>
        <section id="Posts" class="px-4 max-w-[600px] mx-auto">
            <article class="flex items-center justify-between py-2">
                <div class="flex items-center">
                    <Link href="/" class="flex items-center">
                        <img
                            src="https://picsum.photos/id/50/300/320"
                            class="rounded-full w-[38px] h-[38px]"
                        />
                        <h3 class="ml-4 font-extrabold text-[16px]">
                            NAME HERE
                        </h3>
                    </Link>
                    <p class="flex items-center text-gray-500 text-[16px]">
                        <span class="-mt-5 ml-2 mr-[5px] text-[35px]">.</span>
                        <div>DATE HERE</div>
                    </p>
                </div>
                <DotsHorizontal class=" cursor-pointer" :size="27"></DotsHorizontal>
            </article>
            <article class="bg-black rounded-lg w-full min-h-[400px] flex items-center">
                <img class="mx-auto w-full" src="https://picsum.photos/id/45/800/800" >
            </article>
            <LikeSection></LikeSection>
        </section>
    </MainLayout>
</template>

<style>
body {
    background-color: rgba(243, 244, 246, 1);
}
</style>
