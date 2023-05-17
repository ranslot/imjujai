<script setup>
import { Link } from "@inertiajs/vue3";
import { toRefs } from "vue";

const props = defineProps({ userList: Object, ListType: String });
const { userList, ListType } = toRefs(props);

const emit = defineEmits(["closeFollowList"]);

//icon
import ArrowLeft from "vue-material-design-icons/ArrowLeft.vue";
</script>

<template>
    <section
        id="SettingPostOverlay"
        class="fixed flex z-50 top-0 left-0 w-full h-screen bg-black bg-opacity-60 p-3 items-center justify-center"
        @click="emit('closeFollowList')"
    >
        <article
            class="bg-white rounded-xl top-5 mt-5 w-full max-w-[300px] h-full max-h-[400px]"
            @click.stop
        >
            <div
                class="sticky flex items-center justify-between p-1 border-b border-gray-300"
            >
                <ArrowLeft
                    fillColor="#000000"
                    :size="30"
                    @click="emit('closeEditPost')"
                    class="cursor-pointer px-2"
                ></ArrowLeft>
                <h2 class="text-lg font-extrabold">{{ ListType }} List</h2>
                <div class="w-[30px]"></div>
            </div>
            <div
                class="text-center bg-white rounded-xl overflow-y-auto flex flex-col w-full"
            >
                <div v-if="userList.length === 0" class="my-10 text-lg">
                    You have no follower or following
                </div>
                <div
                    v-for="user in userList"
                    class="flex flex-col items-center"
                >
                    <Link
                        :href="route('users.show', { id: user.id })"
                        as="button"
                        class="font-extrabold w-full p-3 text-red-700 text-lg cursor-pointer flex gap-3"
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
                    </Link>
                </div>
            </div>
        </article>
    </section>
</template>
