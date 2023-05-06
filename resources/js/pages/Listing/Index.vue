<template>
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 ">
        <Box v-for="listing in listings" :key="listing.id"> <!--Replaced div for new vue component Box-->
            <div>
                <!--            <Link :href="`/listing/${listing.id}`">-->      <!--This work as well but we're using zyggy to rename routes instead-->
                <!--                <ListingAddress :listing="listing" />-->
                <!--            </Link>-->
                <Link :href="route('listing.show', listing.id)">    <!--If you were to pass several params use [listing.id, ...] array notation, or {listing: listing.id} object notation -->
                    <Price :price="listing.price" class="text-2xl font-bold"></Price> <!-- Passing here additional non-props since its a single root component-->
                    <ListingSpace :listing="listing" class="text-lg"/>  <!--If you want to pass additional styles you must use One Single Root element like this (non-props attributes)-->
                    <ListingAddress :listing="listing" class="text-gray-500"/>
                </Link>
            </div>
            <div>
                <Link :href="route('listing.edit', {listing: listing.id})"> Edit </Link> <!-- Here we use object notation instead -->
            </div>
            <div>
                <Link :href="route('listing.destroy', [listing.id])" method="DELETE" as="button"> Delete </Link> <!-- Here we use array notation instead -->
            </div>
        </Box>
    </div>
</template>

<script setup>      // Syntactic sugar for Composition API
import { Link } from '@inertiajs/inertia-vue3'
import ListingAddress from '../../Components/ListingAddress.vue'
import Box from "../../Components/UI/Box.vue";
import ListingSpace from "../../Components/ListingSpace.vue";
import Price from "../../Components/Price.vue";

defineProps({
    listings: Array,
})
</script>

<style scoped>

</style>

