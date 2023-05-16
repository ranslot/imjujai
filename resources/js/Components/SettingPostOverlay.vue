<script setup>
import { toRefs } from "vue";

const emit = defineEmits(["closeSettingPost", "deleteSelected"]);

const props = defineProps({ deleteType: String, id: Number });
const { deleteType, id } = toRefs(props);
</script>

<template>
    <section
        id="SettingPostOverlay"
        class="fixed flex z-50 top-0 left-0 w-full h-screen bg-black bg-opacity-60 p-3 items-center justify-center"
        @click="emit('closeSettingPost')"
    >
        <div
            class="text-center max-w-sm w-full h-fit mx-auto mt-10 bg-white rounded-xl"
            @click.stop
        >
            <button
                class="font-extrabold w-full p-3 text-red-700 text-lg border-b border-gray-300 cursor-pointer"
                @click="emit('deleteSelected', { deleteType, id })"
            >
                Delete {{ deleteType }}
            </button>
            <button
                v-if="deleteType === 'Post'"
                class="font-extrabold w-full p-3 text-lg border-b border-gray-300 cursor-pointer"
                @click="emit('editSelected', { id })"
            >
                Edit Post
            </button>
            <button
                class="p-3 text-lg cursor-pointer w-full"
                @click="emit('closeSettingPost')"
            >
                Cancle
            </button>
        </div>
    </section>
</template>
