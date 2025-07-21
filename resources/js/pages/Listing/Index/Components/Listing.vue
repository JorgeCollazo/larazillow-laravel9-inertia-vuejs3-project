<template>
    <Box> <!--v-for="listing in listings" :key="listing.id"--> <!--Replaced div for new vue component Box-->
        <div>
            <Link :href="route('listing.show', listing.id)">    <!--If you were to pass several params use [listing.id, ...] array notation, or {listing: listing.id} object notation -->
                <div class="flex items-center gap-1">
                    <Price :price="listing.price" class="text-2xl font-bold"></Price> <!-- Passing here additional non-props since its a single root component-->
                    <div class="text-xs text-gray-500 mx-0.5">
                        <Price :price="monthlyPayment"></Price> pm
                    </div>
                </div>
                <ListingSpace :listing="listing" class="text-lg"/>  <!--If you want to pass additional styles you must use One Single Root element like this (non-props attributes)-->
                <ListingAddress :listing="listing" class="text-gray-500"/>
            </Link>
        </div>
        <div>
            <Link :href="route('listing.edit', {listing: listing.id})"> Edit </Link> <!-- Here we use object notation instead -->
        </div>
<!--        <div> removed-->
<!--            <Link :href="route('listing.destroy', [listing.id])" method="DELETE" as="button"> Delete </Link> &lt;!&ndash; Here we use array notation instead &ndash;&gt;-->
<!--        </div>-->
    </Box>
</template>

<script setup>

import { Link } from '@inertiajs/inertia-vue3'
import ListingAddress from '@/Components/ListingAddress.vue'
import Box from "@/Components/UI/Box.vue";
import ListingSpace from "@/Components/ListingSpace.vue";
import Price from "@/Components/Price.vue";

import {useMonthlyPayment} from "@/Composables/useMonthlyPayment";

const props = defineProps({
    listing: Object
})

const { monthlyPayment } = useMonthlyPayment(props.listing.price, 2.5, 25) // Using detructuring to get just the object
</script>

<style scoped>

</style>
