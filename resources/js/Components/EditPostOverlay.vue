<script setup>
import { ref, toRefs } from "vue";
import { usePage, router } from "@inertiajs/vue3";

const props = defineProps({ post: Object, userLikes: Object });
const { post } = toRefs(props);
const user = usePage().props.auth.user;
</script>
<template></template>
