<script setup>
import { Link, usePage, router, useForm } from "@inertiajs/vue3";
import { ref, defineAsyncComponent, computed } from "vue";

import MenuItem from "@/Components/MenuItem.vue";
import LoadingOverlay from "@/Components/LoadingOverlay.vue";

const user = usePage().props.auth.user;
const notifications = computed(() => usePage().props.notifications);

const CreatePostOverlay = defineAsyncComponent(() =>
    import("@/Components/CreatePostOverlay.vue")
);
const SettingMenuOverlay = defineAsyncComponent(() =>
    import("@/Components/SettingMenuOverlay.vue")
);
const NotificationOverlay = defineAsyncComponent(() =>
    import("@/Components/NotificationOverlay.vue")
);

let showSideBar = ref(false);
let showCreatePost = ref(false);
let searchPostProgress = ref(false);
let showSettingMenu = ref(false);
let showNotification = ref(false);

let form = useForm({
    search: "",
});
function searchPost() {
    router.get(
        "/",
        { search: form.search },
        {
            onSuccess: () => {
                searchPostProgress.value = false;
            },
            onProgress: () => {
                searchPostProgress.value = true;
            },
        }
    );
}

const unreadNotification = computed(() => {
    if (notifications.value.length === 0) return false;

    for (let i = 0; i < notifications.value.length; i++) {
        if (!notifications.value[i].read_at) {
            return true;
        }
    }
    return false;
});

//icon
import Menu from "vue-material-design-icons/Menu.vue";
import Magnify from "vue-material-design-icons/Magnify.vue";
</script>

<template>
    <div id="MainLayout" class="w-full h-screen">
        <header>
            <nav
                id="TopNav"
                class="fixed flex items-center justify-between w-full bg-white h-[65px] border-b border-t border-orange-400 z-20"
            >
                <div
                    class="flex flex-row items-center justify-between min-w-[120px]"
                >
                    <div
                        class="lg:hidden flex items-center justify-between w-[30px] sm:w-[100px] py-auto"
                    >
                        <button
                            @click="showSideBar = !showSideBar"
                            type="button"
                            class="hover:bg-gray-100 sm:mx-5 mx-2"
                        >
                            <Menu
                                fillColor="#808080"
                                :size="36"
                                class="block rounded-2xl px-2"
                            ></Menu>
                        </button>
                    </div>
                    <Link href="/" class="z-20 p-3 ml-5">
                        <img
                            class="md:block hidden"
                            src="/files/logo/imjujai_logo_long.svg"
                            height="50"
                            width="115"
                            alt="Home"
                        />
                        <img
                            class="md:hidden block"
                            src="/files/logo/imjujai_logo.svg"
                            height="50"
                            width="50"
                            alt="Home"
                        />
                    </Link>
                </div>
                <div v-if="$slots.userName">
                    <slot name="userName"></slot>
                </div>
                <div v-if="$slots.search">
                    <slot name="search"></slot>
                </div>

                <form
                    @submit.prevent="searchPost"
                    class="flex items-center justify-end lg:mr-10 mr-2 lg:w-fit gap-2"
                >
                    <input
                        id="Search"
                        v-model="form.search"
                        type="text"
                        class="py-[3px] px-2 sm:w-full w-[80px] rounded-3xl border-gray-400 border focus:boder-1"
                        placeholder="Search. . ."
                    />
                    <button type="submit">
                        <Magnify fillColor="#ffc87a" :size="30"></Magnify>
                    </button>
                </form>
            </nav>

            <nav
                id="SideBar"
                class="fixed h-full bg-white w-[280px] lg:transform-none border-r border-r-orange-400 z-10 transform-gpu transition-all"
                :class="showSideBar ? 'translate-x' : '-translate-x-full'"
            >
                <div class="px-5 pt-[80px]">
                    <Link href="/">
                        <MenuItem iconString="Home" class="mb-3"></MenuItem>
                    </Link>
                    <div class="relative" @click="showNotification = true">
                        <div
                            v-if="unreadNotification"
                            class="z-50 absolute top-3 left-[43px] rounded-full bg-red-600 w-3 h-3 aspect-square border border-red-600"
                            :class="
                                unreadNotification
                                    ? 'animate-pulse transform-gpu'
                                    : ''
                            "
                        ></div>
                        <MenuItem
                            iconString="Notification"
                            class="mb-3"
                        ></MenuItem>
                    </div>

                    <MenuItem
                        iconString="Create"
                        class="mb-3"
                        @click="showCreatePost = true"
                    ></MenuItem>
                    <Link :href="route('users.show', { id: user.id })">
                        <MenuItem iconString="Profile" class="mb-3"></MenuItem>
                    </Link>
                </div>

                <div
                    class="absolute bottom-0 px-5 w-full"
                    @click="showSettingMenu = true"
                >
                    <MenuItem
                        iconString="Setting"
                        class="mb-3 cursor-pointer"
                    ></MenuItem>
                </div>
            </nav>
        </header>
        <main
            class="flex lg:justify-between bg-gray-200 h-full w-[100%-280px] lg:pl-[280px] overflow-auto pt-[61px]"
        >
            <div class="mx-auto">
                <slot></slot>
            </div>
        </main>
        <footer></footer>
        <CreatePostOverlay
            v-if="showCreatePost"
            @close="showCreatePost = false"
        ></CreatePostOverlay>
    </div>
    <SettingMenuOverlay
        v-if="showSettingMenu"
        @closeSettingMenu="showSettingMenu = false"
    ></SettingMenuOverlay>
    <NotificationOverlay
        v-if="showNotification"
        :notifications="notifications"
        @closeNotification="showNotification = false"
    >
    </NotificationOverlay>
    <LoadingOverlay v-if="searchPostProgress"> </LoadingOverlay>
</template>
