<template>
    <Link href="/">Main Page</Link> &nbsp;
    <Link href="/hello">Show Page</Link>

    <div>The page with time: {{ timer }}</div>
    <slot>Default</slot>
</template>

<script setup>
import { ref } from "vue";
import { Link } from '@inertiajs/vue3';

const timer = ref(0)        // It wraps everything into a proxy object, that's why the need to call value property

setInterval(() => timer.value++, 1000)  // No need to use single lines

</script>

<style scoped>

</style>
