<template>
    <div class="flex gap-1">
        <Link v-for="(link, id) in links"
              :key="id" class="py-2 px-2 rounded-md"
              :href="link.url"
              :class="{'bg-indigo-500 dark:bg-indigo-800 text-gray-300' :link.active}"
              v-html="link.label"
        />
<!--            {{ link.label }}   This was changed to v-html tag, because interpolation cannot interpret html -->
    </div>
</template>

<script setup>
import {Link} from "@inertiajs/vue3";
    defineProps({links: Array})
</script>

<style scoped>

</style>
