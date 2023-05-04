<script setup>
import MenuItem from "@/Components/MenuItem.vue";
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <div id="MainLayout" class="w-full h-screen">
        <nav
            v-if="$page.url === '/'"
            id="TopNav"
            class="absolute w-full bg-white h-[61px] border-b border-t border-gray-400 z-0"
        ></nav>
        <nav
            id="SideBar"
            class="fixed h-full bg-white xl:w-[280px] w-[80px] md:block hidden border-r border-r-gray-400 z-2 shadow-2xl"
        >
            <Link href="/">
                <p class="xl:hidden block">home</p>
                <p class="xl:block hidden">HOME</p>
            </Link>
            <div class="px-5 pt-10">
                <MenuItem iconString="Home" class="mb-7"></MenuItem>
                <MenuItem iconString="Search" class="mb-7"></MenuItem>
                <MenuItem iconString="Notification" class="mb-7"></MenuItem>
                <MenuItem iconString="Profile" class="mb-7"></MenuItem>
            </div>
            <Link href="/" class="absolute bottom-0 px-5 w-full">
                <MenuItem iconString="Logout" class="mb-7"></MenuItem>
            </Link>
        </nav>
        <div
            class="flex lg:justify-between bg-gray-200 h-full w-[100%-280px] xl:pl-[280px] md:pl-[100px] overflow-auto pt-[61px]"
        >
            <div
                class="mx-auto md:pt-7 pt-20"
                :class="
                    $page.url === '/' ? 'max-w-2xl w-full' : 'max-w-[1200px]'
                "
            >
                <main>
                    <slot></slot>
                </main>
            </div>
        </div>
    </div>
</template>
