<script setup>
import MenuItem from "@/Components/MenuItem.vue";

import { Link } from "@inertiajs/vue3";
import { ref } from "vue";

let showSideBar = ref(false);
let showSearchBar = ref(false);

function triggerSideBar() {
    showSideBar.value = !showSideBar.value;
}
function triggerSearchBar() {
    showSearchBar.value = !showSearchBar.value;
}

import Menu from "vue-material-design-icons/Menu.vue";
import Close from "vue-material-design-icons/Close.vue";
import Magnify from "vue-material-design-icons/Magnify.vue";
</script>

<template>
    <div id="MainLayout" class="w-full h-screen">
        <nav
            v-if="$page.url === '/'"
            id="TopNav"
            class="fixed flex items-center justify-between lg:justify-end w-full bg-white h-[61px] border-b border-t border-gray-400 z-5"
        >
            <div
                class="lg:hidden flex items-center justify-between w-[100px] py-auto"
            >
                <button
                    @click="triggerSideBar"
                    type="button"
                    class="hover:bg-gray-100 mx-5"
                >
                    <Menu
                        fillColor="#808080"
                        :size="36"
                        class="block pl-2 rounded-2xl"
                    ></Menu>
                </button>
                <Link href="/">
                    <p class="">HOME</p>
                </Link>
            </div>
            <div class="flex items-center justify-between flex-row mr-10">
                <Magnify fillColor="#808080" :size="30"></Magnify>
                <input
                    id="Search"
                    type="text"
                    class="py-0 px-2 ml-2 rounded-3xl lg:w-[400px] w-[120px]"
                    placeholder="Search"
                />
            </div>
        </nav>
        <nav
            id="SideBar"
            class="fixed h-full bg-white w-[280px] lg:transform-none border-r border-r-gray-400 z-10 shadow-2xl transform-gpu transition-all"
            :class="showSideBar ? 'translate-x' : '-translate-x-full'"
        >
            <Link href="/">
                <p>HOME</p>
            </Link>
            <button
                @click="triggerSideBar"
                type="button"
                class="absolute top-0 right-0 m-3 lg:hidden hover:bg-gray-100"
            >
                <Close
                    fillColor="#808080"
                    :size="36"
                    class="block px-2 rounded-2xl"
                ></Close>
            </button>
            <div class="px-5 pt-10">
                <Link href="/"
                    ><MenuItem iconString="Home" class="mb-3"></MenuItem>
                </Link>
                <MenuItem iconString="Search" class="mb-3"></MenuItem>
                <MenuItem iconString="Notification" class="mb-3"></MenuItem>
                <MenuItem iconString="Profile" class="mb-3"></MenuItem>
            </div>
            <Link href="/" class="absolute bottom-0 px-5 w-full">
                <MenuItem iconString="Logout" class="mb-3"></MenuItem>
            </Link>
        </nav>
        <div
            class="flex lg:justify-between bg-gray-100 h-full w-[100%-280px] lg:pl-[280px] overflow-auto pt-[61px]"
        >
            <div
                class="mx-auto lg:pt-7 pt-5"
                :class="
                    $page.url === '/' ? 'max-w-2xl    w-full' : 'max-w-[1200px]'
                "
            >
                <main>
                    <slot></slot>
                </main>
            </div>
        </div>
    </div>
</template>
