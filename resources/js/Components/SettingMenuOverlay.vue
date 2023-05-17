<script setup>
import { Link } from "@inertiajs/vue3";

const emit = defineEmits(["closeSettingMenu"]);
</script>

<template>
    <section
        id="SettingPostOverlay"
        class="fixed flex z-50 top-0 left-0 w-full h-screen bg-black bg-opacity-60 p-3 items-center justify-center"
        @click="emit('closeSettingMenu')"
    >
        <div
            class="text-center max-w-sm w-full h-fit mx-auto mt-10 bg-white rounded-xl"
            @click.stop
        >
            <button
                class="font-extrabold w-full p-3 text-red-700 text-lg border-b border-gray-300 cursor-pointer"
                @click=""
            >
                <Link :href="route('logout')" as="button" method="post"
                    >Log out
                </Link>
            </button>
            <button
                class="p-3 text-lg cursor-pointer w-full"
                @click="emit('closeSettingMenu')"
            >
                Cancle
            </button>
        </div>
    </section>
</template>
