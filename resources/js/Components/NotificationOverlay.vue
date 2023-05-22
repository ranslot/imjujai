<script setup>
import { toRefs } from "vue";
import { markReadNotification } from "@/Helper/UserHelper";

import "@/style/animation.css";
import FadedBackgroundLayout from "@/Layouts/FadedBackgroundLayout.vue";

const props = defineProps({ notifications: Object });
const { notifications } = toRefs(props);

const emit = defineEmits(["closeNotification"]);

function isRead(notification) {
    if (!notification.read_at) {
        markReadNotification(notification.id);
    }
}

//icon
import ArrowLeft from "vue-material-design-icons/ArrowLeft.vue";
import Close from "vue-material-design-icons/Close.vue";
</script>

<template>
    <FadedBackgroundLayout @click="emit('closeNotification')">
        <button
            class="absolute right-3 top-3 z-50 basis-full bg-white bg-opacity-25 rounded-xl cursor-pointer"
        >
            <Close :size="36" fillColor="#000000"></Close>
        </button>
        <article
            id="NotificationOverlay"
            class="bg-white rounded-xl top-5 mt-5 w-full max-w-[400px] h-full max-h-[400px] transform-gpu transition scale-in"
            @click.stop
        >
            <div
                class="sticky flex items-center justify-between p-1 border-b border-gray-300"
            >
                <ArrowLeft
                    fillColor="#000000"
                    :size="30"
                    @click="emit('closeNotification')"
                    class="cursor-pointer px-2"
                ></ArrowLeft>
                <h2 class="text-lg font-extrabold">แจ้งเตือน</h2>
                <div class="w-[30px]"></div>
            </div>

            <div class="bg-white overflow-y-auto flex flex-col w-full">
                <div
                    v-if="notifications.length != 0"
                    v-for="notification in notifications"
                    :key="index"
                >
                    <div
                        class="flex items-center gap-2 p-4 hover:bg-gray-300"
                        :class="notification.read_at ? '' : 'bg-gray-400'"
                        @click="isRead(notification)"
                    >
                        <img
                            :src="notification.data.file"
                            class="rounded-full w-[38px] h-[38px]"
                            width="38"
                            height="38"
                            :alt="notification.data.name"
                        />
                        <p class="font-bold">
                            <a
                                :href="'/user/' + notification.data.id"
                                target="_blank"
                                rel="noreferrer noopener"
                                class="hover:text-blue-500 hover:underline"
                                >{{ notification.data.name }}
                            </a>
                            ได้ติดตามคุณ
                        </p>
                    </div>
                </div>
                <div v-else class="py-6 font-extrabold text-lg text-center">
                    ไม่มีการแจ้งเตือน
                </div>
            </div>
        </article>
    </FadedBackgroundLayout>
</template>
