<script setup>
import MenuItem from "@/Components/MenuItem.vue";
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
                    <h1>XD</h1>
                </a>
            </div>
        </nav>
        <nav
            id="SideBar"
            class="fixed h-full bg-white xl:w-[280px] w-[80px] md:block hidden border-r border-r-gray-400"
        >
            <a href="/">
                <p class="xl:hidden block">xd</p>
                <p class="xl:block hidden">XD</p>
            </a>
            <div class="px-3">
                <MenuItem xdd="Home" />
                <MenuItem xdd="Profile" />
            </div>
        </nav>

        <slot />
    </div>
</template>
