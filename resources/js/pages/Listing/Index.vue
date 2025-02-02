<template>
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 ">
        <Listing v-for="listing in listings" :key="listing.id" :listing="listing"> <!--Replaced div for new vue component Box-->
<!--            <div>--> <!--Since it was copied to the new Listing.vue component-->
<!--                &lt;!&ndash;            <Link :href="`/listing/${listing.id}`">&ndash;&gt;      &lt;!&ndash;This work as well but we're using zyggy to rename routes instead&ndash;&gt;-->
<!--                &lt;!&ndash;                <ListingAddress :listing="listing" />&ndash;&gt;-->
<!--                &lt;!&ndash;            </Link>&ndash;&gt;-->
<!--                <Link :href="route('listing.show', listing.id)">    &lt;!&ndash;If you were to pass several params use [listing.id, ...] array notation, or {listing: listing.id} object notation &ndash;&gt;-->
<!--                    <div class="flex items-center gap-1">-->
<!--                        <Price :price="listing.price" class="text-2xl font-bold"></Price> &lt;!&ndash; Passing here additional non-props since its a single root component&ndash;&gt;-->
<!--                        <div class="text-xs text-gray-500">-->
<!--                            <Price :price="400"></Price> pm-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <ListingSpace :listing="listing" class="text-lg"/>  &lt;!&ndash;If you want to pass additional styles you must use One Single Root element like this (non-props attributes)&ndash;&gt;-->
<!--                    <ListingAddress :listing="listing" class="text-gray-500"/>-->
<!--                </Link>-->
<!--            </div>-->
<!--            <div>-->
<!--                <Link :href="route('listing.edit', {listing: listing.id})"> Edit </Link> &lt;!&ndash; Here we use object notation instead &ndash;&gt;-->
<!--            </div>-->
<!--            <div>-->
<!--                <Link :href="route('listing.destroy', [listing.id])" method="DELETE" as="button"> Delete </Link> &lt;!&ndash; Here we use array notation instead &ndash;&gt;-->
<!--            </div>-->
        </Listing>
    </div>
</template>

<script setup>      // Syntactic sugar for Composition API
import { Link } from '@inertiajs/inertia-vue3'
import ListingAddress from '../../Components/ListingAddress.vue'
import Box from "../../Components/UI/Box.vue";
import ListingSpace from "../../Components/ListingSpace.vue";
import Price from "../../Components/Price.vue";
import Listing from '@/pages/Listing/Index/Components/Listing.vue'

defineProps({
    listings: Array,
})
</script>

<style scoped>

</style>

