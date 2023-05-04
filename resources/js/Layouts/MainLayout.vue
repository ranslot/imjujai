<script setup>
import MenuItem from "@/Components/MenuItem.vue";
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <div id="MainLayout" class="w-full h-screen">
        <nav
            v-if="$page.url === '/'"
            id="TopNav"
            class="fixed z-50 md:hidden block w-full bg-white h-[61px] border-b border-b-gray-400"
        >
            <div class="flex items-center justify-between h-full">
                <a href="/" class="ml-6 w-[100px]">
                    <h1>HOME</h1>
                </a>
            </div>
        </nav>
        <nav
            id="SideBar"
            class="fixed h-full bg-white xl:w-[240px] w-[80px] md:block hidden border-r border-r-gray-400"
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
            class="flex lg:justify-between bg-white h-full w-[100%-240px] xl:pl-[240px] md:pl-[100px] overflow-auto"
        >
            <div
                class="mx-auto md:pt-7 pt-20 md:px-[3%]"
                :class="
                    $page.url === '/' ? 'md:w-9/12 w-full' : 'max-w-[1200px]'
                "
            >
                <main>
                    <slot></slot>
                </main>
            </div>
            <div class="md:block hidden w-3/12 text-black pt-10">
                <Link href="/" class="max-w[300px]">
                    <div class="flex items-center">
                        <img
                            class="rounded-full h-[58px] w-[58px] z-10"
                            src="https://picsum.photos/id/50/300/320"
                        />
                        <div class="pl-4 flex flex-col">
                            <h3 class="text-black font-bold">ID HERE</h3>
                            <h3 class="text-gray-500 font-bold xl:block hidden">
                                FULL NAME HERE
                            </h3>
                        </div>
                    </div>
                </Link>
            </div>
        </div>
    </div>
</template>
