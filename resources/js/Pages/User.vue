<script setup>
import { Head, Link, router } from "@inertiajs/vue3";
import { reactive, toRefs } from "vue";
import MainLayout from "@/Layouts/MainLayout.vue";
import ContentOverlay from "@/Components/ContentOverlay.vue";

let data = reactive({ post: null });
const form = reactive({ file: null });

const props = defineProps({ postByUser: Object, user: Object });
const { postByUser, user } = toRefs(props);

function getUploadUserImage(e) {
    form.file = e.target.files[0];

    router.post("/user", form, {
        preserveState: false,
    });
}

//icon
import Grid from "vue-material-design-icons/Grid.vue";
import Cog from "vue-material-design-icons/Cog.vue";
import BookmarkOutline from "vue-material-design-icons/BookmarkOutline.vue";
import AccountBoxOutline from "vue-material-design-icons/AccountBoxOutline.vue";
import PlayBoxOutline from "vue-material-design-icons/PlayBoxOutline.vue";
</script>

<template>
    <Head title="User" />
    <MainLayout>
        <section
            class="max-w-[1000px] lg:ml-0 md:mx-auto px-4 w-[100vw] pt-3 lg:pt-7"
        >
            <article class="flex items-center lg:justify-between md:pb-5 pl-7">
                <label for="fileUser">
                    <img
                        src="https://picsum.photos/id/50/300/320"
                        class="rounded-full object-contain md:w-[200px] w-[100px] cursor-pointer"
                    />
                </label>
                <input
                    id="fileUser"
                    type="file"
                    class="hidden"
                    @input="getUploadUserImage"
                />
                <div class="ml-6 w-full">
                    <div class="flex items-center md:mb-8 mb-5">
                        <p class="md:mr-6 mr-3 rounded-lg text-[22px]">
                            Name here
                        </p>
                        <button
                            class="md:block hidden md:mr-6 p-1 px-4 rounded-lg text-[16px] font-extrabold bg-gray-200 hover:bg-gray-300 text-gray-400"
                        >
                            Edit Profile
                        </button>
                        <Cog :size="28" class="cursor-pointer"></Cog>
                    </div>
                    <button
                        class="md:hidden mr-6 p-1 max-w-[260px] w-full px-4 rounded-lg text-[17px] font-extrabold bg-gray-200 hover:bg-gray-300 text-gray-400"
                    >
                        Edit Profile
                    </button>
                    <div class="md:block hidden">
                        <div class="flex items-center text-[18px]">
                            <p class="mr-6">
                                <span class="font-extrabold"> 4 </span>
                                posts
                            </p>
                            <p class="mr-6">
                                <span class="font-extrabold"> 123 </span>
                                followers
                            </p>
                            <p class="mr-6">
                                <span class="font-extrabold"> 456 </span>
                                following
                            </p>
                        </div>
                    </div>
                </div>
            </article>

            <article class="md:hidden">
                <div
                    class="flex items-center justify-evenly border-t border-gray-300 mt-8"
                >
                    <div class="text-center w-1/3 p-3">
                        <p class="font-extrabold">4</p>
                        <p class="text-gray-400 font-semibold -mt-1.5">posts</p>
                    </div>
                    <div class="text-center w-1/3 p-3">
                        <p class="font-extrabold">123</p>
                        <p class="text-gray-400 font-semibold -mt-1.5">
                            followers
                        </p>
                    </div>
                    <div class="text-center w-1/3 p-3">
                        <p class="font-extrabold">456</p>
                        <p class="text-gray-400 font-semibold -mt-1.5">
                            following
                        </p>
                    </div>
                </div>

                <div
                    class="flex items-center justify-between w-full border-t border-gray-300"
                >
                    <div
                        class="flex justify-center w-1/3 p-3 border-t border-gray-900"
                    >
                        <Grid
                            :size="28"
                            fillColor="#000000"
                            class="cursor-pointer"
                        ></Grid>
                    </div>
                    <div class="flex justify-center w-1/3 p-3">
                        <BookmarkOutline
                            :size="28"
                            fillColor="#8E8E8E"
                            class="cursor-pointer"
                        ></BookmarkOutline>
                    </div>
                    <div class="flex justify-center w-1/3 p-3">
                        <AccountBoxOutline
                            :size="28"
                            fillColor="#8E8E8E"
                            class="cursor-pointer"
                        ></AccountBoxOutline>
                    </div>
                </div>
            </article>
        </section>
        <section id="ContentSection" class="md:pr-1.5 lg:pl-0 px-auto">
            <article class="md:block mt-10 hidden border-t border-gray-300">
                <div
                    class="flex items-center justify-between max-w-[600px] mx-auto font-extrabold text-gray-600"
                >
                    <div
                        class="flex items-center justify-center w-1/3 p-[17px] border-t border-gray-900"
                    >
                        <Grid
                            :size="18"
                            fillColor="#000000"
                            class="cursor-pointer"
                        ></Grid>
                        <p class="ml-2 -mb-[1px] text-gray-800">POSTS</p>
                    </div>
                    <div
                        class="flex items-center justify-center w-1/3 p-[17px]"
                    >
                        <BookmarkOutline
                            :size="18"
                            fillColor="#000000"
                            class="cursor-pointer"
                        ></BookmarkOutline>
                        <p class="ml-2 -mb-[1px] text-gray-800">SAVED</p>
                    </div>
                    <div
                        class="flex items-center justify-center w-1/3 p-[17px]"
                    >
                        <AccountBoxOutline
                            :size="18"
                            fillColor="#000000"
                            class="cursor-pointer"
                        ></AccountBoxOutline>
                        <p class="ml-2 -mb-[1px] text-gray-800">TAGGED</p>
                    </div>
                </div>
            </article>
            <div class="grid md:gap-4 gap-1 grid-cols-3 relative px-3">
                <ContentOverlay
                    :postByUser="postByUser"
                    @selectPost="($event) => (data.post = $event)"
                ></ContentOverlay>
            </div>
        </section>
    </MainLayout>
</template>

<style>
body {
    background-color: rgba(243, 244, 246, 1);
}
</style>
