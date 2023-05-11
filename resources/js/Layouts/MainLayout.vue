<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import { ref, defineAsyncComponent } from "vue";

import MenuItem from "@/Components/MenuItem.vue";

const user = usePage().props.auth.user;

const CreatePostOverlay = defineAsyncComponent(() =>
    import("@/Components/CreatePostOverlay.vue")
);

let showSideBar = ref(false);
let showSearchBar = ref(false);
let showCreatePost = ref(false);

//icon
import Menu from "vue-material-design-icons/Menu.vue";
import Close from "vue-material-design-icons/Close.vue";
import Magnify from "vue-material-design-icons/Magnify.vue";
</script>

<template>
    <div id="MainLayout" class="w-full h-screen">
        <header>
            <nav
                id="TopNav"
                class="fixed flex items-center justify-between lg:justify-end w-full bg-white h-[61px] border-b border-t border-gray-400 z-5"
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
                    <Link href="/" class="hidden sm:block">
                        <p class="">HOME</p>
                    </Link>
                </div>
                <h1
                    v-if="$page.url !== '/'"
                    class="text-black font-extrabold text-lg lg:hidden block"
                >
                    {{ user.name }}
                </h1>
                <div
                    class="flex items-center justify-end lg:mr-10 mr-2 lg:w-fit"
                >
                    <Magnify fillColor="#808080" :size="27"></Magnify>
                    <input
                        id="Search"
                        type="text"
                        class="py-[3px] px-2 w-[50px] rounded-3xl border-gray-400 hidden sm:block border-0 focus:boder-1"
                        placeholder="Search. . ."
                    />
                </div>
            </nav>

            <nav id="TopNavUser"></nav>
        </header>
        <aside>
            <nav
                id="SideBar"
                class="fixed h-full bg-white w-[280px] lg:transform-none border-r border-r-gray-400 z-10 transform-gpu transition-all"
                :class="showSideBar ? 'translate-x' : '-translate-x-full'"
            >
                <Link href="/">
                    <p>HOME</p>
                </Link>
                <button
                    @click="showSideBar = !showSideBar"
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
                    <Link href="/">
                        <MenuItem iconString="Home" class="mb-3"></MenuItem>
                    </Link>
                    <MenuItem iconString="Notification" class="mb-3"></MenuItem>
                    <MenuItem
                        iconString="Create"
                        class="mb-3"
                        @click="showCreatePost = true"
                    ></MenuItem>
                    <Link :href="route('users.show', { id: user.id })">
                        <MenuItem iconString="Profile" class="mb-3"></MenuItem>
                    </Link>
                </div>
                <Link
                    :href="route('logout')"
                    as="button"
                    method="post"
                    class="absolute bottom-0 px-5 w-full"
                >
                    <MenuItem iconString="Setting" class="mb-3"></MenuItem>
                </Link>
            </nav>
        </aside>
        <main
            class="flex lg:justify-between bg-gray-100 h-full w-[100%-280px] lg:pl-[280px] overflow-auto pt-[61px]"
        >
            <div
                class="mx-auto lg:pt-7 pt-3"
                :class="
                    $page.url === '/' ? 'max-w-3xl w-full' : 'max-w-[1200px]'
                "
            >
                <slot></slot>
            </div>
        </main>
        <footer></footer>
        <CreatePostOverlay
            v-if="showCreatePost"
            @close="showCreatePost = false"
        ></CreatePostOverlay>
    </div>
</template>
