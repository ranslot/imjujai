<script setup>
import { Link } from "@inertiajs/vue3";
import { toRefs } from "vue";

import "@/style/animation.css";
import FadedBackgroundLayout from "@/Layouts/FadedBackgroundLayout.vue";

const props = defineProps({ userList: Object, ListType: String });
const { userList, ListType } = toRefs(props);

const emit = defineEmits(["closeFollowList"]);

//icon
import ArrowLeft from "vue-material-design-icons/ArrowLeft.vue";
import Close from "vue-material-design-icons/Close.vue";
</script>

<template>
    <FadedBackgroundLayout @click="emit('closeFollowList')">
        <button
            class="absolute right-3 top-3 z-50 basis-full bg-white bg-opacity-25 rounded-xl cursor-pointer"
        >
            <Close :size="36" fillColor="#000000"></Close>
        </button>
        <article
            id="FollowListOverlay"
            class="bg-white rounded-xl top-5 mt-5 w-full max-w-[300px] h-full max-h-[400px] transform-gpu transition scale-in"
            @click.stop
        >
            <div
                class="sticky flex items-center justify-between p-1 border-b border-gray-300"
            >
                <ArrowLeft
                    fillColor="#000000"
                    :size="30"
                    @click="emit('closeFollowList')"
                    class="cursor-pointer px-2"
                ></ArrowLeft>
                <h2 class="text-lg font-extrabold">{{ ListType }} List</h2>
                <div class="w-[30px]"></div>
            </div>
            <div
                class="text-center bg-white overflow-y-auto flex flex-col w-full"
            >
                <div v-if="userList.length === 0" class="my-10 text-lg">
                    You have no follower or following
                </div>
                <div
                    v-for="user in userList"
                    class="flex flex-col items-center"
                >
                    <a
                        :href="'/user/' + user.id"
                        target="_blank"
                        rel="noreferrer noopener"
                        class="font-extrabold w-full p-3 text-lg cursor-pointer flex gap-3 text-black hover:bg-gray-200"
                        ><img
                            :src="user.file"
                            width="45"
                            height="45"
                            class="rounded-full w-[45px] h-[45px]"
                            :alt="user.name"
                            loading="lazy"
                        />
                        <h3
                            class="ml-4 font-extrabold text-sm sm:text-base mt-3"
                        >
                            {{ user.name }}
                        </h3>
                    </a>
                </div>
            </div>
        </article>
    </FadedBackgroundLayout>
</template>
