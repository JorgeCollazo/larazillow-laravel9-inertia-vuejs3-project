<template>
    <form @submit.prevent="update">
        <div>
            <div>
                <label>Beds</label>
                <input v-model.number="form.beds" type="text" />
                <div v-if="form.errors.beds">
                    {{ form.errors.beds }}
                </div>
            </div>

            <div>
                <label>Baths</label>
                <input v-model.number="form.baths" type="text" />
                <div v-if="form.errors.beds">
                    {{ form.errors.baths }}
                </div>
            </div>

            <div>
                <label>Area</label>
                <input v-model.number="form.area" type="text" />
                {{ form.errors.area }}
            </div>

            <div>
                <label>City</label>
                <input v-model="form.city" type="text" />
                {{ form.errors.city }}
            </div>

            <div>
                <label>Post Code</label>
                <input v-model="form.code" type="text" />
                {{ form.errors.code }}
            </div>

            <div>
                <label>Street</label>
                <input v-model="form.street" type="text" />
                {{ form.errors.street }}
            </div>

            <div>
                <label>Street Nr</label>
                <input v-model.number="form.street_nr" type="text" />
                {{ form.errors.street_nr }}
            </div>

            <div>
                <label>Price</label>
                <input v-model.number="form.price" type="text" />
                {{ form.errors.price }}
            </div>

            <div>
                <button type="submit">Edit</button>
            </div>
        </div>
    </form>
</template>

<script setup>

import { useForm } from '@inertiajs/inertia-vue3'

const props = defineProps({
    listing: Object,
})

const form = useForm({                 // useForm gives you access to all errors that occur on every attribute
    beds:props.listing.beds,
    baths:props.listing.baths,
    area:props.listing.area,
    city:props.listing.city,
    street:props.listing.street,
    code:props.listing.code,
    street_nr:props.listing.street_nr,
    price:props.listing.price
})

// const create = () => Inertia.post('/listing', form)      // Using just Inertia library
// const create = () => form.post('/listing')

// const update = () => form.put(`/listing/${props.listing.id}`)  // Using zyggy plugin routing instead
const update = () => form.put(route('listing.update', {listing: props.listing.id}))

</script>

<style scoped>
    label {
        margin-right: 2em;
    }
    div {
        padding: 2px
    }
</style>
