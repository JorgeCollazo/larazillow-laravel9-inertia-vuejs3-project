<template>
    <div v-for="listing in listings" :key="listing.id">
        <Link :href="`/listing/${listing.id}`">
            <ListingAddress :listing="listing" />
        </Link>
    </div>
</template>

<script setup>      // Syntactic sugar for Composition API
import {Link} from '@inertiajs/vue3'
import ListingAddress from '../../Components/ListingAddress.vue'

defineProps({
    listings: Array,
})
</script>

<style scoped>

</style>

