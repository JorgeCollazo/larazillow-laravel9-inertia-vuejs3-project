<template>
    <form @submit.prevent="filter">
        <div class="mb-8 mt-4 flex flex-wrap gap-2">
            <div class="flex flex-nowrap items-center">
                <input v-model.number="filterForm.priceFrom"
                    type="text"
                    placeholder="Price from"
                    class="input-filter-l w-28"
                /> <!-- Using Tailwind css to give specific styles to placeholder-->

                <input v-model.number="filterForm.priceTo"
                    type="text"
                    placeholder="Price to"
                    class="input-filter-r w-28"
                /> <!-- Using Tailwind css to give specific styles to placeholder-->
            </div>
            <div class="flex flex-nowrap items-center">
                <select v-model="filterForm.beds" class="input-filter-l w-28">
                    <option :value="null">Beds</option>
                    <option v-for="n in 5" :key="n" :value="n">{{ n }}</option>
                    <option>6+</option>
                </select>
                <select v-model="filterForm.baths" class="input-filter-r w-28">
                    <option :value="null">Baths</option>
                    <option v-for="n in 5" :key="n" :value="n">{{ n }}</option>
                    <option>6+</option>
                </select>
            </div>
            <div class="flex flex-nowrap items-center">
                <input type="text" placeholder="Area from" class="input-filter-l w-28" v-model="filterForm.areaFrom"/>
                <input type="text" placeholder="Area to" class="input-filter-r w-28" v-model="filterForm.areaTo"/>
            </div>
            <button type="submit" class="btn-normal">Filter</button>
            <button type="reset"  class="btn-clear" @click="clear">Clear</button>   <!-- This reset button reset the html elements but not the associated data -->
        </div>
    </form>
</template>

<script setup>

import {useForm} from "@inertiajs/inertia-vue3";

const props = defineProps({
    filters: Object
});

const filterForm = useForm({
    priceFrom: props.filters.priceForm ?? null,
    priceTo: props.filters.priceForm ?? null,
    beds: props.filters.priceForm ?? null,
    baths: props.filters.priceForm ?? null,
    areaFrom: props.filters.priceForm ?? null,
    areaTo: props.filters.priceForm ?? null,
})

const filter = () => {
    filterForm.get(
        route('listing.Index'),
        {
            preserveState: true,
            preserveScroll: true
        }
    )
}

const clear = () => {
    filterForm.reset();
    filter();
}

</script>

<style scoped>

</style>
